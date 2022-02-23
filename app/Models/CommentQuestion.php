<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentQuestion extends Model
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
}
