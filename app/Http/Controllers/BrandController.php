<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Services\BrandService;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $brands = $this->brandService->getAllBrands();
        return view('admin.brand.index', ['brands' => $brands]);
    }

    public function create()
    {
        return view('admin.brand.form');
    }

    public function store(Request $request)
    {
        $this->brandService->store($request);

        return Redirect::route('brands.index')->with('success', 'Created brand successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $brand = $this->brandService->getBrandById($id);

        return view('admin.brand.form', ['brand' => $brand]);
    }

    public function update(Request $request, $id)
    {
        if($request->ajax()){
            return $this->brandService->update($request, $id);
        }

        $this->brandService->update($request, $id);

        return Redirect::route('categories.index')->with('success', 'Updated category successfully!');
    }

    public function destroy($id)
    {
        $this->brandService->destroy($id);

        return Redirect::back()->with('alert', 'Deleted brand successfully!');
    }
}
