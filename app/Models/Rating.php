<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'user_id', 'rating', 'comment'];

  // Rating.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function order()
{
    return $this->belongsTo(Order::class);
}

public function reports()
{
    return $this->hasMany(Report::class);
}
}
