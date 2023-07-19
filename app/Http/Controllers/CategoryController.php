<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;
    private $activePage;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategory();
        $this->activePage = 'category_list';
        return view('admin.category.index', ['categories' => $categories, 'activePage' => $this->activePage]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->activePage = 'category_create';
        return view('admin.category.create-category', ['activePage' => $this->activePage]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->categoryService->store($request->all());

        if (isset($result['error'])) {

            return back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('categories.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        $this->activePage = 'category_list';
        return view('admin.category.edit-category', ['category' => $category, 'activePage' => $this->activePage]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $result = $this->categoryService->update($id, $request->all());

        if (isset($result['error'])) {
            return back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('categories.index')->with('success', 'Sửa sản phẩm thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->categoryService->deleteCategory($id);

        if ($result) {
            return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
        } else {
            return redirect()->route('categories.index')->with('alert', 'Cannot delete category');
        }
    }

    public function child_index()
    {
        $child_categories = $this->categoryService->get_child();
        $this->activePage = 'child_category_list';
        return view('admin.category.sub-category-list', ['child_categories' => $child_categories, 'activePage' => $this->activePage]);
    }

    public function child_create()
    {
        $categories = $this->categoryService->getAllCategory();
        $this->activePage = 'child_category_create';
        return view('admin.category.create-sub-category', ['categories' => $categories, 'activePage' => $this->activePage]);
    }
}
