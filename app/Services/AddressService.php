<?php

namespace App\Services;

use App\Repositories\ProvinceRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\WardRepository;


use App\Models\Brand;

class AddressService
{
    private $provinceRepository;
    private $districtRepository;
    private $wardRepository;

    public function __construct(ProvinceRepository $provinceRepository, DistrictRepository $districtRepository, WardRepository $wardRepository)
    {
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
        $this->wardRepository = $wardRepository;
    }

    public function getProvinces()
    {
        return $this->provinceRepository->getProvinces();
    }

    public function getDistricts($request)
    {
        $term = $request->term;

        $districts = $this->districtRepository->query()->where('province_code', $request->province_code)
                        ->where(function($query) use ($term) {
                            $query->where('name', 'like', '%' . $term . '%')
                                  ->orWhere('code', 'like', '%' . $term . '%');
                        })
                        ->get();

        return response()->json($districts);
    }

    public function getWards($request)
    {
        $term = $request->term;

        $wards = $this->wardRepository->query()->where('district_code', $request->district_code)
                        ->where(function($query) use ($term) {
                            $query->where('name', 'like', '%' . $term . '%')
                                  ->orWhere('code', 'like', '%' . $term . '%');
                        })
                        ->get();

        return response()->json($wards);
    }
}
