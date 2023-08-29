<?php

namespace App\Models;

use App\Http\Controllers\Blade\CategoryController;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_id',
        'timer_expired'
    ];

    protected $appends = ['timer_expired'];

    public function getTimerExpiredAttribute()
    {
        $currentTime = now();
        $deadline = $this->created_at->addMinutes($this->product->category->deadline);
    
        return $currentTime > $deadline;
    }
    




    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function messaegs()
    {
        return $this->hasMany(Message::class);
    }
}
