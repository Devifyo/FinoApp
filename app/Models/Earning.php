<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'earning_date',
        'total_amount',         // Gross from Upwork
        'backup_amount',        // The 10% kept aside
        'distributable_amount', // The remaining 90%
    ];

    protected $casts = [
        'earning_date' => 'date',
    ];

    /**
     * The project that generated this earning.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The payouts generated from this specific earning record.
     */
    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }
}
