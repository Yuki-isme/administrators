<?php

namespace App\Repositories;

use App\Models\Media;



class MediaRepository extends BaseRepository
{

    private $model;

    public function __construct(Media $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function deleteMediaByProductIDAndType($product_id, $type){
        return $this->model->where('mediable_id', $product_id)->where('type', $type)->delete();
    }

    public function deleteMediaByMediableID($mediable_id, $mediable_type){
        return $this->model->where('mediable_id', $mediable_id)->where('$mediable_type', $mediable_type)->delete();
    }
}
