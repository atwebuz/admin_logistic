<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($app);
        return view('applications.index')->with([
            'applications'=> auth()->user()->applications()->latest()->paginate(10),
            'users'=> User::get()->all(),
            ]);
    }

    public function store(StorePostRequest $request)
    {

        if (!$this->canCreateApplication()) {
            return redirect()->back()->with('error', 'You can create only 1 application per day');
        }


        if($request->hasFile('file')){
            $name = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs(
                'files',
                $name,
                'public',
            );
        }

        $application = Application::create([
            'user_id' => auth()->user()->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'file_url' => $path ?? null
        ]);


  
        return redirect('dashboard');
    }

 
    protected function canCreateApplication()
    {
        $last_application = auth()->user()->applications()->latest()->first();

        if (!$last_application) {
            return true; // No previous application found, user can create one
        }

        $last_app_date = Carbon::parse($last_application->created_at)->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');

        return $last_app_date !== $today;
    }
}
