<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Services\BrandService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    private $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        $this->authorize('viewAny', Brand::class);
        $brands = $this->brandService->getAllBrands();
        return view('admin.brand.index', ['brands' => $brands]);
    }

    public function create()
    {
        $this->authorize('create', Brand::class);

        return view('admin.brand.form');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Brand::class);
        $this->brandService->store($request);

        return Redirect::route('brands.index')->with('success', 'Created brand successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $this->authorize('update', Brand::class);
        $brand = $this->brandService->getBrandById($id);

        return view('admin.brand.form', ['brand' => $brand]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Brand::class);
        if($request->ajax()){
            return $this->brandService->update($request, $id);
        }

        $this->brandService->update($request, $id);

        return Redirect::route('brands.index')->with('success', 'Updated category successfully!');
    }

    public function destroy($id)
    {
        $this->authorize('delete', Brand::class);
        $this->brandService->destroy($id);

        return Redirect::back()->with('alert', 'Deleted brand successfully!');
    }
}
