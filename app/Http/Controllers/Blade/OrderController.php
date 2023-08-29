<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Botuser;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        abort_if_forbidden('order.view');
        $orders = Order::with('user', 'product')->orderBy('id', 'desc')->get();
        $orderDeadlines = [];
        foreach ($orders as $order) {
            $orderDeadlines[$order->id] = $order->created_at->addMinutes($order->product->category->deadline)->timestamp;
            // dd($order->product->category->deadline, $order->created_at, $orderDeadlines[$order->id]);
        }
        return view('pages.order.index', compact('orders'));
    }
    public function updateTimer($orderId)
    {
        $order = Order::findOrFail($orderId);
        $orderDeadline = $order->created_at->addMinutes($order->product->category->deadline)->timestamp;

        return response()->json(['deadline' => $orderDeadline]);
    }



    public function submitOrder($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        $user = auth()->user();

        // Check if the user already has an order for this product
        $existingOrder = $user->orders()->where('product_id', $productId)->first();

        if ($existingOrder) {
            return response()->json(['success' => false, 'message' => 'Order already submitted.']);
        }

        // Create a new order
        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $product->id;
        $order->status = 'pending'; // Set an appropriate status value
        $order->save();

        // Update the in_stock status
        $product->in_stock = !$product->in_stock;
        $product->save();

        return redirect()->route('orderIndex');
    }

    public function edit(Order $order)
    {
        $users = User::all(); // Or use any other logic to fetch the users you need

        return view('pages.order.edit', compact('order','users'));
    }
    public function update(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
    
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
        ]);
    
        $selectedUser = User::findOrFail($request->input('user_id'));
    
        if ($selectedUser->hasRole('Manager') || $selectedUser->hasRole('Super admin')) {
            return redirect()->back()->with('error', 'Orders cannot be assigned to a Manager or Super admin.');
        }
    
        $order->user_id = $request->input('user_id');
        $order->save();
    
        return redirect()->route('orderIndex')->with('success', 'Order user updated successfully.');
    }
    

    // public function finish(Request $request, Order $order)
    // {
    //     $orderDefaultQuantity = $order->product->category->default_quantity;
    //     $user = auth()->user();

    //     $user->ball += $orderDefaultQuantity;

    //     $user->save();

    //     $rating = new Rating();
    //     $rating->order_id = $order->id;
    //     $rating->user_id = $user->id; // Foydalanuvchi ID si
    //     $rating->save();

    //     return redirect()->back()->with('success', 'Buyurtma yakunlandi va reyting berildi.');
    // }

    //     public function finish(Request $request, Order $order)
// {
//     if (!$order->is_finished) { // Check if the order is not finished
//         $orderDefaultQuantity = $order->product->category->default_quantity;
//         $user = auth()->user();
//         $user->ball += $orderDefaultQuantity;
//         $user->save();

    //         $rating = new Rating();
//         $rating->order_id = $order->id;
//         $rating->user_id = $user->id; // Foydalanuvchi ID si
//         $rating->save();

    //         $order->is_finished = true;
//         $order->save();
//     }

    //     return redirect()->back()->with('success', 'Buyurtma yakunlandi va ball tayyor.');
// }

    public function finish(Request $request, Order $order)
    {
        if (!$order->is_finished) {
            $orderDefaultQuantity = $order->product->category->default_quantity;
            $user = auth()->user();
            $user->ball += $orderDefaultQuantity;
            $user->save();

            $rating = new Rating();
            $rating->order_id = $order->id;
            $rating->user_id = $user->id;
            $rating->save();

            $order->is_finished = true;
            $order->save();

            // Update the timer status for the finished order
            $order->timer_expired = true;
            $order->save();
        }

        return redirect()->back()->with('success', 'Buyurtma yakunlandi va ball tayyor.');
    }
}