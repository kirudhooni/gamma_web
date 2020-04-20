<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpectralData extends Model
{
    protected $fillable = [
        'device_name', 'date_time', 'filename', 'user_id'
    ];
}
