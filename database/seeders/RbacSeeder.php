<?php

namespace Database\Seeders;

use App\Enum\Auth\PermissionsEnum;
use App\Enum\Auth\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RbacSeeder extends Seeder
{
    private const GUARD = 'api';

    /**
     * Run the database seeds.
     */
    public function run(PermissionRegistrar $permissionRegistrar): void
    {
        $roles = [];
        foreach (RolesEnum::cases() as $role) {
            $roles[$role->value] = Role::findOrCreate($role->value, self::GUARD);
        }

        $permissions = [];
        foreach (PermissionsEnum::cases() as $permission) {
            $permissions[$permission->value] = Permission::findOrCreate($permission->value, self::GUARD);
        }

        $permissionRegistrar->forgetCachedPermissions();

        $userRole = $roles[RolesEnum::USER->value] ?? throw new RuntimeException('User role not found!');
        $adminRole = $roles[RolesEnum::ADMIN->value] ?? throw new RuntimeException('Admin role not found!');

        $userRole->syncPermissions([
            $permissions[PermissionsEnum::PROFILE_VIEW->value]
            ?? throw new RuntimeException('Profile view permission not found!')
        ]);

        $adminRole->syncPermissions([
            $permissions[PermissionsEnum::PROFILE_VIEW->value]
            ?? throw new RuntimeException('Profile view permission not found!'),
            $permissions[PermissionsEnum::ADMIN_VIEW->value]
            ?? throw new RuntimeException('Admin view permission not found!'),
        ]);

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
