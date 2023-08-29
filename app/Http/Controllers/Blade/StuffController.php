<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LogWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StuffController extends Controller
{
    //
    public function index()
    {
        abort_if_forbidden('stuff.view');
        
        $users = User::where('id', '!=', auth()->user()->roles[0]->name == 'Employee')
                    ->whereHas('roles', function ($query) {
                        $query->where('id', 3); // Replace 3 with the actual role ID
                    })
                    ->get();
        //dd($users);
        return view('pages.employers.index', compact('users'));
    }
}
