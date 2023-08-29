<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
    public function index()
    {
        abort_if_forbidden('company.view');
        $companies = Company::all();
        return view('pages.company.index', compact('companies'));
    }

    // Company qo'shish sahifasini ko'rish
    public function add()
    {
        abort_if_forbidden('company.add');
        $companies = Company::all();
        return view('pages.company.add', compact('companies'));
    }

    // Companyni yaratish
    public function create(Request $request)
    {
        if ($request->user_id) {
            $category = Company::find($request->user_id);
            $category->save();
        }

        Company::create([
            'name_ru' => $request->get('name_ru'),
        ]);

        // dd($request);

        return redirect()->route('companyIndex');
    }

    // Companyni tahrirlash sahifasini ko'rish
    public function edit($id)
    {
        abort_if_forbidden('company.edit');
        $company = Company::find($id);
        return view('pages.company.edit', compact( 'company'));
    }

    // Companyni yangilash
    public function update(Request $request, $id)
    {
        $company = Company::find($id);

        $company->name_ru = $request->get('name_ru');
        $company->save();
        return redirect()->route('companyIndex');
    }

    // Companyni o'chirish
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();
        return redirect()->back();
    }
}