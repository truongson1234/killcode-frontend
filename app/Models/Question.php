<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'status_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->select(['name', 'slug']);
    }
    
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function interactions()
    {
        return $this->hasMany(QuestionInteraction::class);
    }
    public function status()
    {
        return $this->hasOne(PostStatus::class, 'status_id');
    }
}
