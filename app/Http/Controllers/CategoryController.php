<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Http\Requests\Category\CategoryRequest;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        //$this->authorize('viewAny', [Category::class, Auth::guard('admin')->user()]);
        $categories = $this->categoryService->getAllCategories();

        return view('admin.category.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('admin.category.form');
    }

    public function store(CategoryRequest $request)
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
        if ($request->ajax()) {
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
        $parents = $this->categoryService->getCategories();

        return view('admin.category.form', ['parents' => $parents, 'sub' => 'sub']);
    }

    public function subStore(CategoryRequest $request)
    {
        $this->categoryService->store($request);
        return Redirect::route('categories.sub_index')->with('success', 'Created sub category successfully!');
    }

    public function subEdit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        $parents = $this->categoryService->getCategories();

        return view('admin.category.form', ['category' => $category, 'parents' => $parents, 'sub' => 'sub']);
    }

    public function subUpdate(Request $request, $id)
    {
        if ($request->ajax()) {
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

    public function getParentByChildren_id(Request $request)
    {

        return $this->categoryService->getParentByChildren_id($request);

        $category = Category::find($request->childId);
        $parentCategory = null;

        while ($category) {
            $parentCategory = $category;
            $category = $category->parent;
        }

        if ($parentCategory) {
            return response()->json($parentCategory);
        }

        return response()->json(null);
    }
}
