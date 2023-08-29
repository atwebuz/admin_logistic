<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
       'category_id','company_id','driver_id', 'description_ru',  'in_stock','level','is_extra'
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function driver()
    {
        return $this->hasOne(Driver::class,'id','driver_id');
    }


    public function toggleAvailability()
    {
        $this->in_stock = !$this->in_stock;
        $this->save();
    }


    public function public_path():string
    {
        return public_path()."/images/";
    }

    public function path():string
    {
        return "/images/".$this->photo;
    }

    public function absolute_path():string
    {
        return public_path().'/images/'.$this->photo;
    }

    public function remove()
    {
        # Delete all releated thins to product

        \Illuminate\Support\Facades\File::delete($this->absolute_path());
        return $this->delete();
    }

}