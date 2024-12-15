<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'reserve_id',
        'ac',
        'temp',
        'monitor',
        'micro',
        'add_lightblub',
        'towel',
        'paper',
        'white_board',
        'add_table',
        'water',
        'coffee',
        'juice',
        'apitize',
        'perfume',
        'clean_before',
        'clean_after',
        'security'
    ];

    public function reserves()
    {
        return $this->belongsTo(Reserve::class);
    }
}
