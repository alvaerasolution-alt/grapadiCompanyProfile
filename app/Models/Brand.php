<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'type',
        'url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public const TYPE_TRUSTED = 'trusted';
    public const TYPE_MEDIA = 'media';

    public const TYPE_OPTIONS = [
        self::TYPE_TRUSTED => 'Trusted By Industry Leaders',
        self::TYPE_MEDIA => 'Media Covered',
    ];

    /**
     * Scope for filtering by type
     */
    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for trusted brands (Industry Leaders)
     */
    public function scopeTrusted(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_TRUSTED);
    }

    /**
     * Scope for media brands (Media Covered)
     */
    public function scopeMedia(Builder $query): Builder
    {
        return $query->where('type', self::TYPE_MEDIA);
    }

    /**
     * Scope for active brands only
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered by sort_order
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('name', 'asc');
    }

    /**
     * Get the logo URL
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
