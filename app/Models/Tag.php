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

    public function followers()
    {
        return $this->belongsToMany(User::class, 'tag_user', 'tag_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
