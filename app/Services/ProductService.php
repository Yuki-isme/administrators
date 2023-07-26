<?php

namespace App\Services;

use App\Repositories\AttributeValueRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductService
{
    private $productRepository;
    private $categoryRepository;
    private $brandRepository;
    private $attributeRepository;
    private $attributeValueRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, BrandRepository $brandRepository, AttributeRepository $attributeRepository, AttributeValueRepository $attributeValueRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->attributeRepository = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
    }

    public function getAllProducts()
    {
        return $this->productRepository->getAllProducts();
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllSub();
    }

    public function getAllBrands()
    {
        return $this->brandRepository->getAllBrands();
    }

    public function store($request)
    {
        try {
            if (isset($request->images)) {
                DB::beginTransaction();

                foreach ($request->file('images') as $image) {

                    $extension = $image->getClientOriginalExtension();
                    $fileName = uniqid(Str::slug($request->input('name')) . '-') . '.' . $extension;
                    $image->move('admin/assets/img/product', $fileName);
                    $images[] = '/admin/assets/img/product/' . $fileName;
                }
                $imagesJson = json_encode($images);

                $product = $this->productRepository->create([
                    'name' => $request->name,
                    'price' => $request->price,
                    'stock' => $request->stock,
                    'sku' => $request->sku,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'content' => $request->content,
                    'is_active' => $request->is_active ?? 0,
                    'feature' => $request->feature ?? 0,
                    'category_id' => $request->category_id,
                    'brand_id' => $request->brand_id,
                    'images' => $imagesJson,
                ]);

                foreach ($request->input('attributesData', []) as $attributeData) {
                    $attribute = $this->attributeRepository->create(['name' => $attributeData['name']]);
                    $this->attributeValueRepository->create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $attributeData['value'],
                    ]);
                }

                DB::commit();

                return Redirect::route('products.index')->with('success', 'Created product successfully!');
            } else {
                throw new \Exception('Invalid image or no image uploaded');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
        }
    }


    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function update($id, $request)
    {
        try {
            $product = $this->productRepository->getById($id);

            DB::beginTransaction();

            if (isset($request->img) && $request->img->isValid()) {
                $file = $request->img;
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid(Str::slug($request->name) . '-') . '.' . $extension;
                $file->move('admin/assets/img/product', $fileName);

                File::delete('admin/assets/img/product/' . $product->path_img);
            } else {

                $fileName = uniqid(Str::slug($request['name']) . '-') . '.' . pathinfo($product->path_img, PATHINFO_EXTENSION);

                File::move('admin/assets/img/product/' . $product->path_img, 'admin/assets/img/product/' . $fileName);
            }

            $product->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'is_active' => $request->is_active ?? 0,
                'path_img' => $fileName,
            ]);

            DB::commit();

            return Redirect::route('products.index')->with('success', 'Updated product successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
        }
    }


    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            $product = $this->productRepository->getById($id);

            if (!$product) {
                throw new \Exception('product not found');
            }

            // Delete the product image (if any)
            if ($product->path_img) {
                File::delete('admin/assets/img/product/' . $product->path_img);
            }

           $product->delete();

            DB::commit();

            return Redirect::back()->with('alert', 'Deleted product successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return Redirect::back()->withErrors(['errors' => $e->getMessage()])->withInput();
        }
    }
}
