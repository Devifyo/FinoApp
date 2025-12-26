<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'client_name', 
        'platform', 
        'status',
        'start_date'
    ];

    // protected $casts = [
    //     'start_date' => 'date',
    // ];
    /**
     * Get all members assigned to this project.
     */
    public function members()
    {
        return $this->hasMany(ProjectMember::class);
    }

    /**
     * Get all monthly earnings records for this project.
     */
    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }
}
