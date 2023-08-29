<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Category extends Model

{
    protected $table = 'category';

    protected $fillable = [
       'name_ru', 'default_quantity','deadline', 'parent_id', 'has_subcategory'
    ];
    


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'category_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'rating_id', 'id');
    }
}
