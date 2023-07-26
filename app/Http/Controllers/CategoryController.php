<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.category.form');
    }

    public function store(Request $request)
    {
        return $this->categoryService->store($request);
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        return view('admin.category.form', ['category' => $category]);
    }

    public function update(Request $request, string $id)
    {
        return $this->categoryService->update($id, $request);
    }

    public function destroy($id)
    {
        return $this->categoryService->destroy($id);
    }

    //

    public function subIndex()
    {
        $categories = $this->categoryService->getAllSub();

        return view('admin.category.index', ['categories' => $categories, 'sub' => 'sub']);
    }

    public function subCreate()
    {
        $parents = $this->categoryService->getAllCategories();

        return view('admin.category.form', ['parents' => $parents, 'sub' => 'sub']);
    }

    public function subStore(Request $request)
    {
        return $this->categoryService->Store($request);
    }

    public function subEdit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        $parents = $this->categoryService->getAllCategories();

        return view('admin.category.form', ['category' => $category, 'parents' => $parents, 'sub' => 'sub']);
    }

    public function subUpdate(Request $request, string $id)
    {
        return $this->categoryService->Update($id, $request);
    }

    public function subDestroy($id)
    {
        return $this->categoryService->destroy($id);
    }
}
