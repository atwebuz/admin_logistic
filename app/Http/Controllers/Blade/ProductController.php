<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // list of categories
    public function index()
    {
        abort_if_forbidden('task.view');
        $products = Product::with('category')->get();
        $sortedProducts = $products->sortByDesc(function ($product) {
            if ($product->level === 'hard') {
                return 3;
            } elseif ($product->level === 'middle') {
                return 2;
            } elseif ($product->level === 'easy') {
                return 1;
            } else {
                return 0; // Default sorting for other levels
            }
        });
        return view('pages.product.index', compact('sortedProducts'));
    }

    public function toggle(Request $request, Product $product)
    {
        $user = auth()->user();
        $userOrder = $user->orders->where('product_id', $product->id)->first();
        
        if ($userOrder) {
            $userOrder->in_stock = !$userOrder->in_stock;
            $userOrder->save();
        } else {
            $user->orders()->create([
                'product_id' => $product->id,
                'in_stock' => true,
            ]);
        }
    
        if ($request->ajax()) {
            return response()->json(['is_active' => !$userOrder->in_stock]);
        }
    
        return redirect()->back()->with('success', 'Product availability updated successfully.');
    }
    // add category page
    public function add()
    {
        abort_if_forbidden('task.add');
        $categories = Category::get()->all();
        $companies = Company::get()->all();
        $drivers = Driver::get()->all();
        $count = 1;
        return view('pages.product.add',compact('categories','companies','drivers','count'));
    }
    
    public function getDriversByCompany(Request $request)
    {
        $drivers = Driver::where('company_id', $request->company_id)->get();
        return response()->json($drivers);
    }

    //create category
    public function create(Request $request)
    {
        $this->validate($request, [
            'description_ru' => 'required',
        ]);

        // Validation for regular task fields (if needed)
        $this->validate($request, [
            'category_id' => 'required',
            'company_id' => 'required',
            'driver_id' => 'required',
            'level' => 'required',
            // Add other validation rules for regular task fields
        ]);

        // Create the task
        Product::create([
            'category_id' => $request->get('category_id'),
            'company_id' => $request->get('company_id'),
            'driver_id' => $request->get('driver_id'),
            'description_ru' => $request->get('description_ru') ?? '',
            'level' => $request->get('level'),
            'in_stock' => '1',
            'is_extra' => $request->has('is_extra'),

        ]);

        return redirect()->route('taskIndex');
    }

    public function showExtraTaskView()
    {
        $extraTaskData = [
            'extraData' => 'This is extra task specific data.',
        ];
    
        $products = Product::with('category')->get();
        $sortedProducts = $products->sortByDesc(function ($product) {
            if ($product->level === 'hard') {
                return 3;
            } elseif ($product->level === 'middle') {
                return 2;
            } elseif ($product->level === 'easy') {
                return 1;
            } else {
                return 0; // Default sorting for other levels
            }
        });
    
        return view('pages.product.extra', [
            'extraData' => $extraTaskData['extraData'], // Pass the correct value
            'sortedProducts' => $sortedProducts,
        ]);
    }
    

    
    // edit page
    public function edit($id)
    {
        abort_if_forbidden('task.edit');
        $product = Product::find($id);
        $categories = Category::get()->all();
        $companies = Company::get()->all();
        $drivers = Driver::get()->all();
        $products = [];//CategoryController::getAllfromJowi();
        $count = 1;
        return view('pages.product.edit',compact('product','categories','products','companies','drivers','count'));
    }

    // update data
    public function update(Request $request,$id)
    {

        // $this->validate($request,[
        //     'deadline' => 'required|max:60',
        // ]);

        $product = Product::find($id);

        $product->category_id = $request->get('category_id');
        $product->company_id = $request->get('company_id');
        $product->driver_id = $request->get('driver_id');
        $product->description_ru = $request->get('description_ru') ?? '';
        $product->level = $request->get('level') ;
        $product->is_extra = $request->has('is_extra');

        $product->save();

        return redirect()->route('taskIndex');
    }

    // delete permission
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back();
    }

    public function toggleProductActivation($id)
    {
        $product = Product::where('id',$id)->first();
        $product->in_stock = ! $product->in_stock;
        $product->save();
        return [
            'is_active' => $product->in_stock
        ];
    }
}