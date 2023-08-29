<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'body'];
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function application(){return $this->belongsTo(Application::class);}
}
