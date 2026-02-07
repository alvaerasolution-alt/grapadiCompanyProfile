<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all resources and their CRUD actions
        $resources = [
            'article',
            'brand',
            'category',
            'client',
            'company-timeline',
            'executive-team',
            'interaction',
            'lead',
            'permission',
            'portfolio',
            'project',
            'role',
            'service',
            'tag',
            'user',
        ];

        $actions = ['view', 'view_any', 'create', 'update', 'delete', 'delete_any', 'restore', 'restore_any', 'force_delete', 'force_delete_any'];

        // Create resource permissions
        $allPermissions = [];
        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                $permissionName = "{$action}_{$resource}";
                $allPermissions[] = $permissionName;
                Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
            }
        }

        // Page permissions
        $pagePermissions = [
            'view_dashboard',
            'view_site_settings',
            'update_site_settings',
        ];

        foreach ($pagePermissions as $permissionName) {
            $allPermissions[] = $permissionName;
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // Create roles
        // Super Admin - has all permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdminRole->syncPermissions($allPermissions);

        // Admin - most permissions except permission/role management
        $adminPermissions = array_filter($allPermissions, function($perm) {
            return !str_contains($perm, '_permission') && !str_contains($perm, '_role');
        });
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($adminPermissions);

        // Content Manager - can manage content resources
        $contentResources = ['article', 'brand', 'category', 'portfolio', 'service', 'tag', 'company-timeline', 'executive-team'];
        $contentPermissions = [];
        foreach ($contentResources as $resource) {
            foreach ($actions as $action) {
                $contentPermissions[] = "{$action}_{$resource}";
            }
        }
        $contentPermissions[] = 'view_dashboard';
        $contentManagerRole = Role::firstOrCreate(['name' => 'content_manager', 'guard_name' => 'web']);
        $contentManagerRole->syncPermissions($contentPermissions);

        // Sales/CRM - can manage clients, leads, interactions, projects
        $crmResources = ['client', 'lead', 'interaction', 'project'];
        $crmPermissions = [];
        foreach ($crmResources as $resource) {
            foreach ($actions as $action) {
                $crmPermissions[] = "{$action}_{$resource}";
            }
        }
        $crmPermissions[] = 'view_dashboard';
        $salesRole = Role::firstOrCreate(['name' => 'sales', 'guard_name' => 'web']);
        $salesRole->syncPermissions($crmPermissions);

        // Viewer - view only permissions
        $viewerPermissions = [];
        foreach ($resources as $resource) {
            $viewerPermissions[] = "view_{$resource}";
            $viewerPermissions[] = "view_any_{$resource}";
        }
        $viewerPermissions[] = 'view_dashboard';
        $viewerRole = Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
        $viewerRole->syncPermissions($viewerPermissions);

        // Create default users
        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@grapadi.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->syncRoles(['super_admin']);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@grapadi.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['admin']);

        // Content Manager
        $contentManager = User::firstOrCreate(
            ['email' => 'content@grapadi.com'],
            [
                'name' => 'Content Manager',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $contentManager->syncRoles(['content_manager']);

        // Sales
        $sales = User::firstOrCreate(
            ['email' => 'sales@grapadi.com'],
            [
                'name' => 'Sales Team',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        $sales->syncRoles(['sales']);

        $this->command->info('Permissions and Roles seeded successfully!');
        $this->command->table(
            ['Role', 'Permissions Count'],
            [
                ['super_admin', count($allPermissions)],
                ['admin', count($adminPermissions)],
                ['content_manager', count($contentPermissions)],
                ['sales', count($crmPermissions)],
                ['viewer', count($viewerPermissions)],
            ]
        );
        $this->command->info('Default users created:');
        $this->command->table(
            ['Email', 'Role', 'Password'],
            [
                ['superadmin@grapadi.com', 'super_admin', 'password123'],
                ['admin@grapadi.com', 'admin', 'password123'],
                ['content@grapadi.com', 'content_manager', 'password123'],
                ['sales@grapadi.com', 'sales', 'password123'],
            ]
        );
    }
}
