<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'room_name'
    ];

    public function reserves()
    {
        return $this->hasMany(Reserve::class, 'room_id');
    }

    public function categories()
    {
        return $this->belongsTo(CategoryRoom::class, 'category_id');
    }
}
