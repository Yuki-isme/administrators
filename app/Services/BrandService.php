<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Exceptions\CommonException;

class BrandService
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllBrands()
    {
        return $this->brandRepository->getAllBrands();
    }

    public function store($request)
    {
        try {
            if (isset($request->img) && $request->img->isValid()) {
                DB::beginTransaction();

                $file = $request->img;
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid(Str::slug($request->name) . '-') . '.' . $extension;
                $file->move('admin/assets/img/brand', $fileName);

                $this->brandRepository->create([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'is_active' => $request->is_active ?? 0,
                    'path_img' => $fileName,
                ]);

                DB::commit();
            } else {
                throw new \Exception('Invalid image or no image uploaded');
            }
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
                throw new \Exception('Category not found!');
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

            if (isset($request->img) && $request->img->isValid()) {
                $file = $request->img;
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid(Str::slug($request->name) . '-') . '.' . $extension;
                $file->move('admin/assets/img/brand', $fileName);

                File::delete('admin/assets/img/brand/' . $brand->path_img);
            } else {

                $fileName = uniqid(Str::slug($request['name']) . '-') . '.' . pathinfo($brand->path_img, PATHINFO_EXTENSION);

                File::move('admin/assets/img/brand/' . $brand->path_img, 'admin/assets/img/brand/' . $fileName);
            }

            $brand->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'is_active' => $request->is_active ?? 0,
                'path_img' => $fileName,
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

            $brand = $this->brandRepository->getById($id);

            if (!$brand) {
                throw new \Exception('Brand not found');
            }

            // Delete the brand image (if any)
            if ($brand->path_img) {
                File::delete('admin/assets/img/brand/' . $brand->path_img);
            }

           $brand->delete();

            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();

            throw new CommonException($e->getMessage());
        }
    }
}
