<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main(){  
       return redirect('dashboard');
    }
    public function dashboard(){

        return view('dashboard')->with([
            'applications' => Application::latest()->paginate(3),
            'answers' => Answer::all(),
            'users' => User::all()
        ]);
    }
}
