<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'full_name',
        'track_num',
        'eastern_time',
        'comment',
        'tag',
        'blocked_until'
    ]; 

    protected $dates = ['blocked_until'];

    protected static function booted()
    {
        static::saving(function ($driver) {
            if ($driver->tag === 'DOT') {
                $blockedUntil = Carbon::now()->addDays(8);
                $driver->blocked_until = $blockedUntil; // Correct attribute name
            }
        });
    }

    public function canBeEdited()
    {
        return !$this->blocked_until || $this->blocked_until->isPast(); // Correct attribute name
    }

    public function scopeBlocked($query)
    {
        return $query->where('blocked_until', '>', Carbon::now()); // Correct attribute name
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
