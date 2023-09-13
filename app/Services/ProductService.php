<?php

namespace App\Services;

use App\Repositories\AttributeValueRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\BrandRepository;
use App\Repositories\TagRepository;
use App\Repositories\MediaRepository;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Exceptions\CommonException;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;

class ProductService
{
    private $productRepository;
    private $categoryRepository;
    private $brandRepository;
    private $tagRepository;
    private $attributeRepository;
    private $attributeValueRepository;
    private $mediaRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        BrandRepository $brandRepository,
        TagRepository $tagRepository,
        AttributeRepository $attributeRepository,
        AttributeValueRepository $attributeValueRepository,
        MediaRepository $mediaRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->tagRepository = $tagRepository;
        $this->attributeRepository = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->mediaRepository = $mediaRepository;
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

            $product = $this->productRepository->create([
                'name' => $request->name,
                'price' => $request->price ?? 0,
                'sale_price' => $request->sale_price ?? 0,
                'stock' => $request->stock ?? 0,
                'sku' => $request->sku,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'content' => $request->content,
                'is_active' => $request->is_active ?? 0,
                'is_feature' => $request->is_feature ?? 0,
                'is_hot' => $request->is_hot ?? 0,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
            ]);

            if (isset($request->tags)) {
                $tagIds = []; // Sử dụng một mảng để chứa các id của các tag

                foreach ($request->tags as $item) {
                    if (is_numeric($item)) {
                        // Nếu là một id (đã tồn tại), thêm id vào mảng $tagIds
                        $tagIds[] = $item;
                    } else {
                        // Nếu không phải id, tạo mới tag và thêm id của tag mới vào mảng $tagIds
                        $tag = $this->tagRepository->create(['name' => $item]);
                        $tagIds[] = $tag->id;
                    }
                }

                // Đồng bộ hóa tất cả các tag (cả cũ và mới) với sản phẩm
                $product->tags()->sync($tagIds);
            }


            foreach ($request->input('attributesData', []) as $attributeData) {
                $attribute = $this->attributeRepository->create(['name' => $attributeData['name']]);
                $this->attributeValueRepository->create([
                    'product_id' => $product->id,
                    'attribute_id' => $attribute->id,
                    'value' => $attributeData['value'],
                ]);
            }

            if ($request->hasFile('thumbnail')) {
                $thumbImage = $request->file('thumbnail');
                $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $thumbImage->getClientOriginalName();
                $url =  $thumbImage->storeAs('thumbnails', $imageName, 'public');

                $this->mediaRepository->create([
                    'title' => $imageName,
                    'url' => $url,
                    'type' => 'thumbnail',
                    'mediable_type' => Product::class,
                    'mediable_id' => $product->id,
                ]);
            }

            if (isset($request->catalog)) {
                foreach ($request->catalog as $item) {
                    $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $item->getClientOriginalName();
                    $url = $item->storeAs('catalog', $imageName, 'public');

                    $this->mediaRepository->create([
                        'title' => $imageName,
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
        return $this->productRepository->getProductById($id);
    }

    public function update($request, $id)
    {
        try {
            $product = $this->productRepository->getProductById($id);

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

            $product = $this->productRepository->update($id, [
                'name' => $request->name,
                'price' => $request->price ?? 0,
                'sale_price' => $request->sale_price ?? 0,
                'stock' => $request->stock ?? 0,
                'sku' => $request->sku,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'content' => $request->content,
                'is_active' => $request->is_active ?? 0,
                'is_feature' => $request->is_feature ?? 0,
                'is_hot' => $request->is_hot ?? 0,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
            ]);

            if (isset($request->tags)) {
                $tagIds = []; // Sử dụng một mảng để chứa các id của các tag

                foreach ($request->tags as $item) {
                    if (is_numeric($item)) {
                        // Nếu là một id (đã tồn tại), thêm id vào mảng $tagIds
                        $tagIds[] = $item;
                    } else {
                        // Nếu không phải id, tạo mới tag và thêm id của tag mới vào mảng $tagIds
                        $tag = $this->tagRepository->create(['name' => $item]);
                        $tagIds[] = $tag->id;
                    }
                }

                // Đồng bộ hóa tất cả các tag (cả cũ và mới) với sản phẩm
                $product->tags()->sync($tagIds);
            }


            foreach ($request->input('attributesData', []) as $attributeData) {

                $attribute = $this->attributeRepository->findByName($attributeData['name']);

                if (!$attribute) {
                    // Create new attribute if not exists
                    $attribute = $this->attributeRepository->create(['name' => $attributeData['name']]);
                }

                $existingAttributeValue = $this->attributeValueRepository->getByProductIdAndAttributeId($product->id, $attribute->id);

                if ($existingAttributeValue->isNotEmpty()) {
                    // Update existing attribute value

                    $this->attributeValueRepository->update($existingAttributeValue[0]->id, ['value' => $attributeData['value']]);
                } else {
                    // Create new attribute value
                    $this->attributeValueRepository->create([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute->id,
                        'value' => $attributeData['value'],
                    ]);
                }
            }


            //Delete attribute values that are not in the request
            foreach ($this->attributeValueRepository->getAllValueByProductId($product->id) as $existingAttributeValue) {
                //get attribute_id

                $attributeId = $existingAttributeValue->attribute_id;


                $isAttributeValueInRequest = collect($request->input('attributesData', []))->contains(function ($attributeValueData) use ($attributeId) {
                    //kiểm tra attribute có tồn tại trong bảng attribute không và id của nó có trùng với attribute_id trong bảng value không
                    $attribute = $this->attributeRepository->findByName($attributeValueData['name']);
                    return $attribute && $attribute->id === $attributeId;
                });
                //nếu không có attribute hoặc không trùng id thì xóa value
                if (!$isAttributeValueInRequest) {
                    $existingAttributeValue->delete();

                    //delete attribute have id not exist in value
                    if (!$this->attributeValueRepository->existsByAttributeId($attributeId)) {
                        $this->attributeRepository->delete($attributeId);
                    }
                }
            }


            if ($request->hasFile('thumbnail')) {
                Storage::disk('public')->delete($product->thumbnail->url);
                $this->mediaRepository->deleteMediaByProductIDAndType($product->id, 'thumbnail');
                $thumbImage = $request->file('thumbnail');
                $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $thumbImage->getClientOriginalName();
                $url =  $thumbImage->storeAs('thumbnails', $imageName, 'public');

                $this->mediaRepository->create([
                    'title' => $imageName,
                    'url' => $url,
                    'type' => 'thumbnail',
                    'mediable_type' => Product::class,
                    'mediable_id' => $product->id,
                ]);
            }

            if (isset($request->catalog_update)) {
                foreach ($product->media as $item) {
                    if (!in_array($item->id, $request->catalog_update)) {
                        Storage::disk('public')->delete($item->url);
                        $this->mediaRepository->delete($item->id);
                    }
                }
            }

            if (isset($request->catalog)) {
                foreach ($request->catalog as $item) {
                    $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $item->getClientOriginalName();
                    $url = $item->storeAs('catalog', $imageName, 'public');

                    $this->mediaRepository->create([
                        'title' => $imageName,
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


    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            $product = $this->productRepository->getProductById($id);

            if (!$product) {
                throw new \Exception('product not found');
            }

            $attributeValue = $product->attributeValue;

            // Xóa các attribute_values liên quan đến sản phẩm
            $attributeValue->each(function ($item) {
                $item->delete();
            });

            foreach ($attributeValue as $item) {
                $attributeId = $item->attribute_id;

                // Kiểm tra xem còn bản ghi nào khác liên quan đến attribute này không
                $check = $this->attributeValueRepository->existsByAttributeId($attributeId);

                if (!$check) {
                    // Không còn liên quan, xóa attribute
                    $this->attributeRepository->getById($attributeId)->delete();
                }
            }

            $product->tags()->detach();

            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail->url);
            }

            if ($product->media) {
                foreach ($product->media as $Item) {
                    Storage::disk('public')->delete($Item->url);
                }
            }

            $this->mediaRepository->deleteMediaByMediableID($product->id, Product::class);

            $product->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }

    public function getProducts($request)
    {
        $query = $this->productRepository->query();

        if ($request->q) {
            $query->where('name', 'like', "%$request->q%");
        }

        $products = $query->paginate(10, '*', 'page', $request->page);

        $data = [
            'lastPage' => $products->lastPage(),
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'text' => $product->name,
                    'image' => asset('storage/' . $product->thumbnail->url),
                    'name' => $product->name,
                    'price' => $product->cart_price,
                    'discount' => $product->price - $product->cart_price,
                    'stock' => $product->stock,
                ];
            }),
        ];

        return $data;
    }
}
