<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'datetime:H:i d-m-Y',
        'updated_at' => 'datetime:H:i d-m-Y',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }
}
