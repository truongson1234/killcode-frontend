<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sender_id', 'title', 'content', 'type_notification', 'route', 'read'];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getRouteAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setRouteAttribute($value)
    {
        $this->attributes['route'] = json_encode($value);
    }
}
