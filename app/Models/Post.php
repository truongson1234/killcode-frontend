<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'title', 'body', 'views', 'likes', 'tags'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTagsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode($value);
    }
}
