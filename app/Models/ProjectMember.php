<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    use HasFactory;

   protected $fillable = [
        'project_id',
        'user_id',
        'role',                 // 'bidder', 'developer', 'idle'
        'is_main_developer',    // boolean
        'contribution_share',   // decimal, e.g., 15.00
    ];

    /**
     * The project this membership belongs to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The user who holds this membership.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
