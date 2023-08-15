<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Redirect;

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
        $this->categoryService->store($request);

        return Redirect::route('categories.index')->with('success', 'Created category successfully!');
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
        if($request->ajax()){
            return $this->categoryService->update($request, $id);
        }
        $this->categoryService->update($request, $id);
        return Redirect::route('categories.index')->with('success', 'Updated category successfully!');
    }

    public function destroy($id)
    {
        $this->categoryService->destroy($id);

        return Redirect::back()->with('alert', 'Deleted category successfully!');
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
        $this->categoryService->store($request);
        return Redirect::route('categories.sub_index')->with('success', 'Updated sub category successfully!');
    }

    public function subEdit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        $parents = $this->categoryService->getAllCategories();

        return view('admin.category.form', ['category' => $category, 'parents' => $parents, 'sub' => 'sub']);
    }

    public function subUpdate(Request $request, $id)
    {
        if($request->ajax()){
            return $this->categoryService->update($request, $id);
        }
        $this->categoryService->update($request, $id);
        return Redirect::route('categories.sub_index')->with('success', 'Updated sub category successfully!');
    }

    public function subDestroy($id)
    {
        return $this->categoryService->destroy($id);
    }

    public function getChildrenByParent_id(Request $request)
    {
        return $this->categoryService->getChildrenByParent_id($request);
    }
}
