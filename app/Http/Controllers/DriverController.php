<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Tag;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        abort_if_forbidden('driver.view');
        // $drivers = Driver::orderBy('id', 'DESC')->get();
        $drivers = Driver::all();

        foreach ($drivers as $driver) {
            if ($driver->canBeEdited()) {
                $driver->daysRemaining = now()->diffInDays($driver->blocked_until);
                $driver->message = ($driver->daysRemaining > 8)
                    ? "You have more than 8 days before the blocked_until date."
                    : "You have {$driver->daysRemaining} days or less before the blocked_until date.";
            } else {
                $driver->message = 'Driver is blocked and cannot be edited.';
            }
        }
        
        return view('pages.driver.index', compact('drivers'));
    }

    // Kategoriya qo'shish sahifasini ko'rish
    public function add(Driver $driver)
    {
        abort_if_forbidden('driver.add');
        $drivers = Driver::all();
        $companies = Company::all();
        return view('pages.driver.add', compact('drivers','companies'));
    }


    // public function add()
    // {
    //     abort_if_forbidden('driver.add');
    //     $companies = Company::get()->all();
    //     $count = 1;
    //     return view('pages.product.add',compact('companies','count'));
    // }

    // Kategoriyani yaratish
    public function create(Request $request)
    {
        // dd($request);
        if ($request->user_id) {
            $driver = Driver::find($request->user_id);

            $driver->save();
        }

        Driver::create([
            'company_id' => $request->get('company_id'),
            'full_name' => $request->get('full_name'),
            'track_num' => $request->get('track_num'),
            'eastern_time' => $request->get('eastern_time'),
            'comment' => $request->get('comment'),
            'tag' => $request->get('tag'),
            
        ]);

        // dd($request);

        return redirect()->route('driverIndex');
    }

    // Kategoriyani tahrirlash sahifasini ko'rish
    public function edit($id)
    {
        abort_if_forbidden('driver.edit');
    
        $driver = Driver::find($id);
    
        if (!$driver) {
            return redirect()->back()->with('warning', 'Driver not found.');
        }
        
        if (!$driver->canBeEdited()) {
            return redirect()->back()->with('warning', 'Driver is blocked and cannot be edited.');
        }
    
        // Calculate days remaining and message
        $daysRemaining = now()->diffInDays($driver->blocked_until);
        $message = ($daysRemaining > 8)
            ? "You have more than 8 days before the blocked_until date."
            : "You have {$daysRemaining} days or less before the blocked_until date.";
    
        // Check and update tag if necessary
        if ($driver->tag === 'DOT' && $driver->blocked_until->isPast()) {
            $driver->tag = 'NOT DOT';
            $driver->save();
        }
    
        $companies = Company::all();
    
        return view('pages.driver.edit', compact('driver', 'companies', 'message', 'daysRemaining'));
    }

    // Kategoriyani yangilash
    public function update(Request $request, $id)
    {
        $driver = Driver::find($id);

        if ($driver->tag === 'DOT' && $driver->blocked_until->isPast()) {
            $driver->tag = 'NOT DOT';
        }
    

        $driver->company_id = $request->get('company_id');
        $driver->full_name = $request->get('full_name');
        $driver->track_num = $request->get('track_num');
        $driver->eastern_time = $request->get('eastern_time');
        $driver->comment = $request->get('comment');
        $driver->tag = $request->get('tag');

        $driver->save();
        return redirect()->route('driverIndex');
    }

    // Kategoriyani o'chirish
    public function destroy($id)
    {
        $driver = Driver::find($id);
        $driver->delete();
        return redirect()->back();
    }
}