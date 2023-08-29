<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    
        if (User::count() === 1) {
            // Assign Super Admin role to the first user
            $superAdminRole = Role::where('name', 'Super Admin')->first();
            $user->assignRole($superAdminRole);
        } else {
            // Assign default role (e.g., 'User') to other users
            $defaultRole = Role::where('name', 'User')->first();
            $user->assignRole($defaultRole);
        }
    
        return $user;
    }

    protected function initializeRolesAndPermissions()
    {
        $rolesAndPermissions = [
            'Super Admin' => [
                'permission.show', 'permission.edit',  'permission.add', 'permission.delete', 
                'roles.show', 'roles.edit', 'roles.add','roles.delete', 
                'user.show','user.edit', 'user.add','user.delete', 'api-user.add','api-user.view', 'api-user.edit','api-user-passport.view',
                'task.view', 'task.edit','task.add','task.delete',         
                'order.view', 'order.edit','order.add','order.delete',         
                'company.view', 'company.edit','company.add','company.delete',         
                'driver.view', 'driver.edit','driver.add','driver.delte','monitoring.view'          
            ],

            'Manager' => [
                'permission.show', 'permission.edit',  'permission.add', 'permission.delete',  
                'roles.show',
                'user.show','user.edit','user.add','user.delete','api-user.view','api-user-passport.view',
                'task.view', 'task.edit','task.add','task.delete',         
                'order.view', 'order.edit','order.add','order.delete',         
                'company.view', 'company.edit','company.add','company.delete',         
                'driver.view', 'driver.edit','driver.add','driver.delete',  
                'stuff.view', 'stuff.edit','stuff.add','stuff.delete','monitoring.view'
         
            ],
            'Employee' => ['task.view','order.view','daily.view'], // Only show permission for Employee
  
        ];

        foreach ($rolesAndPermissions as $roleName => $permissions) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);

            $role->syncPermissions($permissions);

            User::first()->assignRole($role);
        }
    }
}
