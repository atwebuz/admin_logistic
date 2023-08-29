<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::with('order')->get();
        return view('pages.rating.index', compact('ratings'));
    }   

    public function daily()
    {
        $ratings = Rating::with('order')->get();
        return view('pages.rating.daily', compact('ratings'));
    }   


}
