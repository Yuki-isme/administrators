<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CommonException;
use App\Repositories\MediaRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Brand;

class BrandService
{
    private $brandRepository;
    private $mediaRepository;

    public function __construct(BrandRepository $brandRepository, MediaRepository $mediaRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->mediaRepository = $mediaRepository;
    }

    public function getAllBrands()
    {
        return $this->brandRepository->getAllBrands();
    }

    public function store($request)
    {
        try {
                DB::beginTransaction();

                $brand = $this->brandRepository->create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'description' => $request->description,
                    'is_active' => $request->is_active ?? 0,
                ]);

                if ($request->hasFile('thumbnail')) {
                    $thumbImage = $request->file('thumbnail');
                    $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $thumbImage->getClientOriginalName();
                    $url =  $thumbImage->storeAs('thumbnails', $imageName, 'public');

                    $this->mediaRepository->create([
                        'title' => $imageName,
                        'url' => $url,
                        'type' => 'thumbnail',
                        'mediable_type' => Brand::class,
                        'mediable_id' => $brand->id,
                    ]);
                }

                DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }


    public function getBrandById($id)
    {
        return $this->brandRepository->getById($id);
    }

    public function update($request, $id)
    {
        try {
            $brand = $this->brandRepository->getById($id);

            if (!$brand) {
                throw new \Exception('Brand not found!');
            }

            DB::beginTransaction();

            if ($request->ajax()) {
                $brand = $this->brandRepository->update($id, [
                    'is_active' => $request->is_active,

                ]);
                DB::commit();

                return response()->json([
                    'title' => 'Update Status',
                    'message' => 'Update Status for ' . $brand->name . ' successfully!',
                    'is_active' => $brand->is_active,
                ]);
            }

            $brand->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'is_active' => $request->is_active ?? 0,

            ]);

            if ($request->hasFile('thumbnail')) {
                Storage::disk('public')->delete($brand->thumbnail->url);
                $this->mediaRepository->deleteMediaByProductIDAndType($brand->id, 'thumbnail');
                $thumbImage = $request->file('thumbnail');
                $imageName = Carbon::now()->format('Y-m-d-H-i-s') . '-' . $thumbImage->getClientOriginalName();
                $url =  $thumbImage->storeAs('thumbnails', $imageName, 'public');

                $this->mediaRepository->create([
                    'title' => $imageName,
                    'url' => $url,
                    'type' => 'thumbnail',
                    'mediable_type' => Brand::class,
                    'mediable_id' => $brand->id,
                ]);
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

            $brand = $this->brandRepository->getById($id);

            if (!$brand) {
                throw new \Exception('Brand not found');
            }

            if ($brand->products){
                throw new \Exception('Can brand has products');
            }

            if ($brand->thumbnail) {
                Storage::disk('public')->delete($brand->thumbnail->url);
            }

            $this->mediaRepository->deleteMediaByMediableID($brand->id, Brand::class);

           $brand->delete();

            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }
}
