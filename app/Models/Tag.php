<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followed_tags', 'tag_id', 'user_id');
    }
}
