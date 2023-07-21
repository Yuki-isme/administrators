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

    public function index()
    {
        $categories = $this->categoryService->getAllCategory();
        $this->activePage = 'category_list';
        return view('admin.category.index', ['categories' => $categories, 'activePage' => $this->activePage]);
    }

    public function create()
    {
        $this->activePage = 'category_create';
        return view('admin.category.create-category', ['activePage' => $this->activePage]);
    }

    public function store(Request $request)
    {
        $result = $this->categoryService->store($request->all());

        if (isset($result['error'])) {

            return back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('categories.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        $this->activePage = 'category_list';
        return view('admin.category.edit-category', ['category' => $category, 'activePage' => $this->activePage]);
    }

    public function update(Request $request, string $id)
    {
        $result = $this->categoryService->update($id, $request->all());

        if (isset($result['error'])) {
            return back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('categories.index')->with('success', 'Sửa sản phẩm thành công!');
    }


    public function destroy(string $id)
    {
        $result = $this->categoryService->deleteCategory($id);

        if (isset($result['error'])) {

            return redirect()->route('categories.index')->with('alert', $result['error']);
        }
        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
    }

    public function getChildCategories()
    {
        $child_categories = $this->categoryService->getChildCategories();

        return view('admin.category.sub-category-list', ['child_categories' => $child_categories, 'activePage' => $this->activePage]);
    }

    public function childCreate()
    {
        $categories = $this->categoryService->getAllCategory();

        return view('admin.category.create-sub-category', ['categories' => $categories, 'activePage' => $this->activePage]);
    }
}
