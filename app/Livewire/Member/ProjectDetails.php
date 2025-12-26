<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Project;
use App\Models\Payout;
use Illuminate\Support\Facades\Auth;

class ProjectDetails extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        // Security: Ensure the logged-in user is actually a member of this project
        $exists = $project->members()->where('user_id', Auth::id())->exists();
        
        if (! $exists) {
            abort(403, 'You are not assigned to this project.');
        }

        $this->project = $project;
    }

    public function render()
    {
        $userId = Auth::id();

        // 1. My Total Earnings from THIS project only
        $myProjectEarnings = Payout::where('user_id', $userId)
            ->where('is_paid', true)
            ->whereHas('earning', function($q) {
                $q->where('project_id', $this->project->id);
            })
            ->sum('amount');

        // 2. My Payout History for THIS project
        $myPayouts = Payout::where('user_id', $userId)
            ->where('is_paid', true)
            ->whereHas('earning', function($q) {
                $q->where('project_id', $this->project->id);
            })
            ->with('earning') // to get earning date
            ->latest('paid_at')
            ->get();

        // 3. Team Members (Who else is on this project?)
        // Eager load the user details
        $teamMembers = $this->project->members()->with('user')->get();

        return view('livewire.member.project-details', [
            'my_earnings' => $myProjectEarnings,
            'payouts' => $myPayouts,
            'team' => $teamMembers,
        ])->layout('layouts.app', ['title' => $this->project->name]);
    }
}