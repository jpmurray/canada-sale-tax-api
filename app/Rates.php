<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'province', 'pst', 'hst', 'gst', 'applicable', 'type', 'start', 'source',
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'pst' => 'float',
        'hst' => 'float',
        'gst' => 'float',
        'applicable' => 'float',
        'since' => 'datetime'
    ];
}
