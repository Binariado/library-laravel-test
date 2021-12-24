<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $email_administrator = 'administrator@library.com';

        if (!$user = User::query()->where('email', $email_administrator)->first())

            $user = new User(array(
                'name' => 'Administrator',
                'email' => 'administrator@library.com',
                'password' => Hash::make('password'),
                'last_name' => 'Administrator',
                'document_type' => 'CC',
                'document_number' => 134343,
                'address' => 'kra 10',
                'phone' => '12434343',
            ));

            $user->save();

        $author = [
            "Create author",
            "Edit author",
            "Delete author",
            "View author"
        ];

        $root_permission = [
            "Assign role",
            "Delete role",
            "View roles"
        ];

        $permissions = [$author, $root_permission];

        foreach ($permissions as $permission) {
            if (is_array($permission)) {
                foreach ($permission as $name) {
                    Permission::findOrCreate($name, 'api');
                }
            } elseif (is_string($permission)) {
                Permission::findOrCreate($permission, 'api');
            }
        }

        $roles = [
            'root' => [$root_permission],
            'admin' => [$author],
            'reader' => []
        ];

        foreach ($roles as $key => $role_permissions) {
            $role = Role::findOrCreate($key, 'api');

            foreach ($role_permissions as $permission) {
                if (is_array($permission)) {
                    foreach ($permission as $name) {
                        if (!$p = Permission::findByName($name))
                            $role = Role::findByName($key);
                            $role->givePermissionTo($p);
                    }
                } elseif (is_string($permission)) {
                    if (!$p = Permission::findByName($permission))
                        $role = Role::findByName($key);
                        $role->givePermissionTo($p);
                }
            }
        }

        $user->assignRole('root');
        $user->assignRole('admin');
    }
}
