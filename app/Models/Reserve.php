<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'room_id',
        'reserver',
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'prepare',
        'status',
        'users_amount'
    ];

    public function configs()
    {
        return $this->hasOne(Config::class, 'reserve_id');
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function roomMembers()
    {
        return $this->hasMany(RoomMember::class, 'reserve_id');
    }

    public function reserver()
    {
        return $this->belongsTo(User::class, 'reserver');
    }
}
