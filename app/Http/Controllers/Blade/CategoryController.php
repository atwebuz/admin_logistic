<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Kategoriyalarni ro'yxatini ko'rish
    public function index()
    {
        abort_if_forbidden('category.view');
        $categories = Category::get()->all();
        return view('pages.category.index', compact('categories'));
    }

    // Kategoriya qo'shish sahifasini ko'rish
    public function add()
    {
        abort_if_forbidden('category.add');
        $categories = Category::all();
        return view('pages.category.add', compact('categories'));
    }

    // Kategoriyani yaratish
    public function create(Request $request)
    {
        if ($request->user_id) {
            $category = Category::find($request->user_id);
            $category->has_subcategory = 1;
            $category->save();
        }

        Category::create([
            'name_ru' => $request->get('name_ru'),
            'default_quantity' => $request->get('default_quantity'),
            'deadline' => $request->get('deadline'),
        ]);

        // dd($request);

        return redirect()->route('categoryIndex');
    }

    // Kategoriyani tahrirlash sahifasini ko'rish
    public function edit($id)
    {
        abort_if_forbidden('category.edit');
        $category = Category::find($id);
        $categories = Category::all();
        return view('pages.category.edit', compact('category', 'categories'));
    }

    // Kategoriyani yangilash
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $category->name_ru = $request->get('name_ru');
        $category->default_quantity = $request->get('default_quantity');
        $category->deadline = $request->get('deadline');
        $category->save();
        return redirect()->route('categoryIndex');
    }

    // Kategoriyani o'chirish
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back();
    }
}
