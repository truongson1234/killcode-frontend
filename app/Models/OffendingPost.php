<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffendingPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'reason', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
