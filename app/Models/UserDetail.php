<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar_head',
        'avatar_hair',
        'avatar_face',
        'avatar_skin',
        'avatar_shirt',
        'avatar_back'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
