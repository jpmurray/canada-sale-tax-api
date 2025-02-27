<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version',
        'endpoint',
        'client',
        'user_agent',
    ];

    /**
     * Get the user that owns the hit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
