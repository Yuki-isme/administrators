<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;

class TagController extends Controller
{
    public function getTags(Request $request)
    {
        if ($request->ajax()) {
            $query = Tag::query();

            if ($request->q) {
                $query->where('name', 'like', "%$request->q%");
            }

            $tags = $query->paginate(10, '*', 'page', $request->page);

            $tagsMap = $tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'text' => $tag->name,
                ];
            });
            $data = [
                'lastPage' => $tags->lastPage(),
                'data' => $tagsMap,
            ];

            return response()->json($data);
        }
    }

    public function index()
    {
        $tags = Tag::with('products')->get();

        return view('admin.tag.index', ['tags' => $tags]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::get();

        return view('admin.tag.form', ['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tag = Tag::create(['name' => $request->name]);

        $tag->products()->sync($request->products);

        return Redirect::route('tags.index');
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
    public function edit(string $id)
    {
        $tag = Tag::find($id);
        $products = Product::get();

        return view('admin.tag.form', ['tag' => $tag, 'products' => $products]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tag = Tag::find($id);

        $tag->update(['name' => $request->name]);

        $tag->products()->sync($request->products);

        return Redirect::route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::find($id);

        $tag->products()->detach();

        $tag->delete();

        return Redirect::route('tags.index');
    }
}
