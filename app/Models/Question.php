<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
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

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\LikeQuestion', 'question_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\CommentQuestion', 'question_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'tag_question', 'tag_id', 'question_id');
    }
}
