<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Services\BrandService;

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
        return $this->brandService->store($request);
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

    public function update(Request $request, string $id)
    {
        return $this->brandService->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->brandService->destroy($id);
    }
}
