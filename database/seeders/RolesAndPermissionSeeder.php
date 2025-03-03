<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Permissions
        Permission::create(['name' => 'create-role']);
        Permission::create(['name' => 'edit-role']);
        Permission::create(['name' => 'delete-role']);

        // Assign permissions to roles
        Role::findByName('admin')->givePermissionTo(['create-role', 'edit-role', 'delete-role']);

        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'first_name' => 'Admin',
            'password' => Hash::make('12345678'),
        ]);
        $admin->assignRole('admin');

        $user = User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'first_name' => 'user',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('user');
    }
}
