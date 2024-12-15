<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    use HasFactory;

    protected $fillable = ['reserve_id', 'user_id', 'seat'];

    public function reserves()
    {
        return $this->belongsTo(Reserve::class, 'reserve_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
