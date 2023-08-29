<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    

    public function index()
    {
        abort_if_forbidden('monitoring.view');
        $drivers = Driver::all();
        $products = Product::all();
        $categories = Category::all();
        $companies = Company::all();
        $orders = Order::latest()->get();

        return view('pages.monitoring.index', compact('drivers', 'products', 'categories', 'companies', 'orders'));
    }

    public function sendDefaultMessage(Order $order)
    {
        // Set default message content
        $defaultMessage = 'The admin is calling you';
    
        // Create a new message for the order's user
        Message::create([
            'user_id' => $order->user->id,
            'order_id' => $order->id,
            'message' => $defaultMessage,
            'created_at' => now(), 

        ]);
    
        return redirect()->back()->with('success', 'Default message sent successfully.');
    }

    public function deleteAllMessages()
    {
    // Delete all messages for the authenticated user
        auth()->user()->messages()->delete();

        return redirect()->back()->with('success', 'All messages deleted successfully.');
    }
}
