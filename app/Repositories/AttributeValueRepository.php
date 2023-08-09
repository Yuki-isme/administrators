<?php

namespace App\Repositories;

use App\Models\AttributeValue;


class AttributeValueRepository extends BaseRepository
{

    private $model;

    public function __construct(AttributeValue $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getByProductIdAndAttributeId($product_id, $attribute_id)
    {
        return $this->model->where('product_id', $product_id)->where('attribute_id', $attribute_id)->get();
    }

    public function getAllValueByProductId($product_id)
    {
        return $this->model->where('product_id', $product_id)->get();
    }

    public function existsByAttributeId($attributeId)
    {
        return $this->model->where('attribute_id', $attributeId)->exists();
    }
}
