<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version',
        'endpoint',
        'count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
