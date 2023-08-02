<?php

namespace App\Services;

use App\Repositories\AttributeValueRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\BrandRepository;
use App\Repositories\MediaRepository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Exceptions\CommonException;
use Illuminate\Support\Facades\Storage;


class ProductService
{
    private $productRepository;
    private $categoryRepository;
    private $brandRepository;
    private $attributeRepository;
    private $attributeValueRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository, BrandRepository $brandRepository, AttributeRepository $attributeRepository, AttributeValueRepository $attributeValueRepository, readonly MediaRepository $mediaRepository)
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
        return $this->categoryRepository->getAllCategories();
    }

    public function getAllBrands()
    {
        return $this->brandRepository->getAllBrands();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
                $thumbImages = $request->file('thumbnail');
                $imagesName = Carbon::now() . '-' . $thumbImages->getClientOriginalName();
                dd($thumbImages->putFileAs('thumbnails', $imagesName, 'public'));

            $product = $this->productRepository->create([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'sku' => $request->sku,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'content' => $request->content,
                'is_active' => $request->is_active ?? 0,
                'is_feature' => $request->is_feature ?? 0,
                'is_hot' => $request->is_hot ?? 0,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                //'images' => $imagesJson,
            ]);

            foreach ($request->input('attributesData', []) as $attributeData) {
                $attribute = $this->attributeRepository->create(['name' => $attributeData['name']]);
                $this->attributeValueRepository->create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'value' => $attributeData['value'],
                ]);
            }

            if ($request->hasFile('thumbnail')) {
                $thumbImages = $request->file('thumbnail');
                $imagesName = Carbon::now() . '-' . $thumbImages->getClientOriginalName();
                dd($thumbImages->storeAs('thumbnails', $imagesName, 'public'));
                $url = $thumbImages->storeAs('thumbnails', $imagesName, 'public');
                $this->mediaRepository->create([
                    'title' => $imagesName,
                    'url' => $url,
                    'type' => 'thumbnail',
                    'mediable_type' => Product::class,
                    'mediable_id' => $product->id,
                ]);
            }

            if (isset($request->catalog)) {
                foreach ($request->catalog as $item) {
                    $imagesName = Carbon::now() . '-' . $item->getClientOriginalName();
                    $url = $item->storeAs('thumbnails', $imagesName, 'public');
                    $this->mediaRepository->create([
                        'title' => $imagesName,
                        'url' => $url,
                        'type' => 'catalog',
                        'mediable_type' => Product::class,
                        'mediable_id' => $product->id,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }


    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function update($request, $id)
    {
        try {
            $product = $this->productRepository->getById($id);

            DB::beginTransaction();

            if ($request->ajax()) {
                $product = $this->productRepository->update($id, [
                    'is_active' => $request->is_active,

                ]);
                DB::commit();

                return response()->json([
                    'title' => 'Update Status',
                    'message' => 'Update Status for ' . $product->name . ' successfully!',
                    'is_active' => $product->is_active,
                ]);
            }

            // if (isset($request->img) && $request->img->isValid()) {
            //     $file = $request->img;
            //     $extension = $file->getClientOriginalExtension();
            //     $fileName = uniqid(Str::slug($request->name) . '-') . '.' . $extension;
            //     $file->move('admin/assets/img/product', $fileName);

            //     File::delete('admin/assets/img/product/' . $product->path_img);
            // } else {

            //     $fileName = uniqid(Str::slug($request['name']) . '-') . '.' . pathinfo($product->path_img, PATHINFO_EXTENSION);

            //     File::move('admin/assets/img/product/' . $product->path_img, 'admin/assets/img/product/' . $fileName);
            // }

            $product->update($id, [
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'sku' => Str::slug($request->name),
                'slug' => $request->slug,
                'description' => $request->description,
                'content' => $request->content,
                'is_active' => $request->is_active ?? 0,
                'is_feature' => $request->is_feature ?? 0,
                'is_hot' => $request->is_hot ?? 0,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
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
            // if ($product->path_img) {
            //     File::delete('admin/assets/img/product/' . $product->path_img);
            // }

            $product->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }
}
