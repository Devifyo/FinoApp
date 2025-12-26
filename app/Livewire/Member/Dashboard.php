<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Project;
use App\Models\Payout;
use Livewire\WithPagination; // Ensure this is imported
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination; // This trait enables pagination features

    public function render()
    {
        $userId = Auth::id();

        // 1. Total Earnings
        $myTotalEarnings = Payout::where('user_id', $userId)
            ->where('is_paid', true)
            ->sum('amount');

        // 2. Active Count
        $myActiveProjectsCount = Project::whereHas('members', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'active')->count();

        // 3. Recent Payouts
        $recentPayouts = Payout::with(['earning.project'])
            ->where('user_id', $userId)
            ->where('is_paid', true)
            ->latest('paid_at')
            ->take(5)
            ->get();

        // 4. Projects List - NOW PAGINATED
        $myProjects = Project::whereHas('members', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['members' => function($q) use ($userId) {
            $q->where('user_id', $userId);
        }])
        ->latest() // Good to show newest first
        ->paginate(5); // <--- Changed from get() to paginate(5)

        return view('livewire.member.dashboard', [
            'total_earnings' => $myTotalEarnings,
            'active_projects_count' => $myActiveProjectsCount,
            'recent_payouts' => $recentPayouts,
            'my_projects' => $myProjects
        ])->layout('layouts.app', ['title' => 'My Dashboard']);
    }
}