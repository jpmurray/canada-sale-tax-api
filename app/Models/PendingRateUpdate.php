<?php

namespace App\Models;

use Database\Factories\PendingRateUpdateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingRateUpdate extends Model
{
    /** @use HasFactory<PendingRateUpdateFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'province',
        'pst',
        'hst',
        'gst',
        'applicable',
        'type',
        'start',
        'source',
        'status',
        'reviewed_by',
        'reviewed_at',
        'review_notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pst' => 'float',
        'hst' => 'float',
        'gst' => 'float',
        'applicable' => 'float',
        'start' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user who submitted this pending rate update.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who reviewed this pending rate update.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
