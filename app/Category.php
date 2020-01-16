<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Product;

class Category extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded =[];

    public function products()
    {
      return $this->belongsToMany(Product::class,'category_product','category_id','product_id');
    }

    public function childrens()
    {
        return $this->belongsToMany(Category::class,'category_parent','category_id','parent_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
   
    
}

