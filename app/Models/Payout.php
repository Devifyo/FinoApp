<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'earning_id',
        'user_id',
        'role_at_time',       // Snapshot of role for history
        'amount',             // Actual $ value
        'percentage_applied', // % used for calculation
        'is_paid',    // <--- Added
        'paid_at',    // <--- Added
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'paid_at' => 'datetime',
    ];

    /**
     * The specific earning record this payout comes from.
     */
    public function earning()
    {
        return $this->belongsTo(Earning::class);
    }

    /**
     * The user receiving the money.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
