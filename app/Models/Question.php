<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'views', 'likes'];

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
        return $this->hasMany(Comment::class, 'id', 'post_id');
    }
}
