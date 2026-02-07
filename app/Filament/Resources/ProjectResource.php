<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Client;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Proyek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\Select::make('client_id')
                            ->label('Client')
                            ->relationship('client', 'company_name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('company_name')
                                    ->required()
                                    ->maxLength(200),
                                Forms\Components\TextInput::make('pic_name')
                                    ->required()
                                    ->maxLength(100),
                            ]),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Proyek')
                            ->required()
                            ->maxLength(200),
                        Forms\Components\Select::make('type')
                            ->label('Tipe')
                            ->options(Project::TYPE_OPTIONS)
                            ->default('development')
                            ->required(),
                        Forms\Components\DatePicker::make('deadline')
                            ->label('Deadline'),
                        Forms\Components\Select::make('status')
                            ->options(Project::STATUS_OPTIONS)
                            ->default('active')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Progress & Budget')
                    ->schema([
                        Forms\Components\TextInput::make('progress')
                            ->label('Progress (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->default(0),
                        Forms\Components\TextInput::make('budget')
                            ->label('Budget (Rp)')
                            ->numeric()
                            ->prefix('Rp'),
                    ])->columns(2),

                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.company_name')
                    ->label('Client')
                    ->searchable()
                    ->sortable()
                    ->placeholder('No Client'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Proyek')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'development' => 'info',
                        'marketing' => 'warning',
                        'execution' => 'success',
                        'design' => 'primary',
                        'consulting' => 'gray',
                        'research' => 'purple',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => Project::TYPE_OPTIONS[$state] ?? $state),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->sortable()
                    ->color(fn (Project $record): string => $record->is_overdue ? 'danger' : 'gray'),
                Tables\Columns\TextColumn::make('progress')
                    ->label('Progress')
                    ->suffix('%')
                    ->sortable()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 50 => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'completed' => 'info',
                        'on_hold' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => Project::STATUS_OPTIONS[$state] ?? $state),
                Tables\Columns\TextColumn::make('budget')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('client_id')
                    ->label('Client')
                    ->relationship('client', 'company_name'),
                Tables\Filters\SelectFilter::make('type')
                    ->options(Project::TYPE_OPTIONS),
                Tables\Filters\SelectFilter::make('status')
                    ->options(Project::STATUS_OPTIONS),
                Tables\Filters\Filter::make('overdue')
                    ->label('Overdue')
                    ->query(fn ($query) => $query->where('deadline', '<', now())->where('status', '!=', 'completed')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
