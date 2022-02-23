<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'datetime:H:i d-m-Y',
        'updated_at' => 'datetime:H:i d-m-Y',
    ];

    public function questions()
    {
        return $this->belongsToMany('App\Models\Question', 'tag_question', 'question_id', 'tag_id');
    }
}
