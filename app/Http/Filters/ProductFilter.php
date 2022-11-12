<?php

namespace App\Http\Filters;

class ProductFilter extends QueryFilter
{
    public function name(string $name)
    {
        $this->builder->where('name', $name);
    }

    public function category(string $category)
    {
        $this->builder->where('category', $category);
    }

    public function image_url_not_null()
    {
        $this->builder->whereNotNull('image_url');
    }

    public function image_url_null()
    {
        $this->builder->whereNull('image_url');
    }
}
