<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'province',
        'pst',
        'hst',
        'gst',
        'applicable',
        'type',
        'start',
        'source',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'created_at',
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
        'start' => 'datetime'
    ];
}
