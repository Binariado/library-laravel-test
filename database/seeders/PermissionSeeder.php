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
            "Update author",
            "View author"
        ];

        $publisher = [
            "Create publisher",
            "Update publisher",
            "View publisher"
        ];

        $editor = [
            "Create editor",
            "Update editor",
            "View editor"
        ];

        $gender = [
            "Create gender",
            "Update gender",
            "View gender"
        ];

        $root_permission = [
            "Assign role",
            "Delete role",
            "View roles",
            "Delete editor",
            "Delete publisher",
            "Delete author",
            "Delete gender"
        ];

        $permissions = [$author, $publisher, $editor, $gender, $root_permission];

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
            'admin' => [$author, $publisher, $editor, $gender],
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
