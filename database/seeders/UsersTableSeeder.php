<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $roles = ['Super Admin', 'Manager', 'Employee'];
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Create permissions
        $permissions = [
            'permission.show', 'permission.edit',  'permission.add', 'permission.delete', 
            'roles.show', 'roles.edit', 'roles.add','roles.delete', 
            'user.show','user.edit', 'user.add','user.delete', 'api-user.add','api-user.view', 'api-user.edit','api-user-passport.view',
            'task.view', 'task.edit','task.add','task.delete',         
            'order.view', 'order.edit','order.add','order.delete',         
            'company.view', 'company.edit','company.add','company.delete',         
            'driver.view', 'driver.edit','driver.add','driver.delete',
            'stuff.view', 'stuff.edit','stuff.add','stuff.delete',
            'daily.view','rating.view','daily.view','monitoring.view'
         ];
         
         foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // Create users with roles and permissions
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Super Admin', // Role name should match exactly
                'permissions' => $permissions, // Assign all permissions to Super Admin
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'role' => 'Manager', // Role name should match exactly
                'permissions' => [
                    'permission.show', 'permission.edit',  'permission.add', 'permission.delete',  
                    'roles.show',
                    'user.show','user.edit','user.add','user.delete','api-user.view','api-user-passport.view',   
                    'task.view', 'task.edit','task.add','task.delete',         
                    'order.view', 'order.edit','order.add','order.delete',         
                    'company.view', 'company.edit','company.add','company.delete',         
                    'driver.view', 'driver.edit','driver.add','driver.delete',
                    'stuff.view', 'stuff.edit','stuff.add','stuff.delete','monitoring.view'
            
                ],
            ],
            [
                'name' => 'Employee',
                'email' => 'employee@example.com',
                'password' => Hash::make('password'),
                'role' => 'Employee', // Role name should match exactly
                'permissions' => ['task.view','order.view','daily.view' ], // Only show permission for Employee
            ],
            [
                'name' => 'test',
                'email' => 'test@gmail.com',
                'password' => Hash::make('test@gmail.com'),
                'role' => 'Employee', // Role name should match exactly
                'permissions' => ['task.view','order.view','daily.view' ], // Only show permission for Employee
            ],
        ];

    

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

            $user->assignRole($userData['role']);
            $user->givePermissionTo($userData['permissions']);
        }
    }
}
