<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Filterable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'description',
        'category',
        'image_url',
    ];
}
