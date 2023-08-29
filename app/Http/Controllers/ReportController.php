<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{

    public function index()
    {
        abort_if_forbidden('stuff.view');
        
        $users = User::where('id', '!=', auth()->user()->roles[0]->name == 'Employee')
                    // ->orderByDesc('id')
                    ->whereHas('roles', function ($query) {
                        $query->where('id', 3); // Replace 3 with the actual role ID
                    })
                    ->get();
        //dd($users);
        return view('pages.report.index', compact('users'));
    }


    public function showUserReports($userId, Request $request)
    {
        $user = User::findOrFail($userId);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $query = Rating::where('user_id', $userId)
                       ->with('reports.order.product.category');
    
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
    
        $ratings = $query->get();
    
        return view('pages.report.show', compact('user', 'ratings','startDate', 'endDate'));
    }
    
    // http://127.0.0.1:8000/reports/{userId}/generate-pdf?start_date=2023-08-01&end_date=2023-08-15
    // http://127.0.0.1:8000/reports/3?start_date=2023-08-18&end_date=2023-08-28
    

    // public function generatePDF($userId)
    // {
    //     $user = User::findOrFail($userId);
    
    //     $ratings = Rating::where('user_id', $userId)->with('reports.order.product.category')->get();
    
    //     $pdf = PDF::loadView('myPDF', ['ratings' => $ratings, 'user' => $user]);
        
    //     return $pdf->download('ratings.pdf');
    // }

    public function generatePDF(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
    
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $query = Rating::where('user_id', $userId)
                       ->with('reports.order.product.category');
    
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
    
        $ratings = $query->get();
    
        // Pass data to the PDF view
        $pdf = PDF::loadView('myPDF', [
            'ratings' => $ratings,
            'user' => $user,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    
        return $pdf->download('ratings.pdf');
    }
    
    
    
}
