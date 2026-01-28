<?php

namespace Database\Seeders;

use App\Enum\Permissions\PermissionsEnum;
use App\Enum\Roles\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = 'api';

        foreach (RolesEnum::cases() as $role) {
            Role::findOrCreate($role->value, $guard);
        }

        foreach (PermissionsEnum::cases() as $permission) {
            Permission::findOrCreate($permission->value, $guard);
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $userRole = Role::findByName(RolesEnum::USER->value, $guard);
        $adminRole = Role::findByName(RolesEnum::ADMIN->value, $guard);

        $userRole->syncPermissions([
            PermissionsEnum::PROFILE_VIEW->value,
        ]);

        $adminRole->syncPermissions([
            PermissionsEnum::PROFILE_VIEW->value,
            PermissionsEnum::ADMIN_VIEW->value,
        ]);



//        $user = User::firstOrCreate([
//            'name' => 'user',
//            'email' => 'user@gmail.com',
//            'password' => Hash::make('password'),
//        ]);
//
//        $admin = User::firstOrCreate([
//            'name' => 'admin',
//            'email' => 'admin@gmail.com',
//            'password' => Hash::make('password'),
//        ]);

        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            ['name' => 'user', 'password' => Hash::make('password')]
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'admin', 'password' => Hash::make('password')]
        );

        $user->syncRoles(RolesEnum::USER->value);
        $admin->syncRoles(RolesEnum::ADMIN->value);
    }
}
