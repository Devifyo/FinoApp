<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use App\Models\Earning;
use App\Models\Payout;

class Dashboard extends Component
{
    public function render()
    {
        // 1. Fetch Stats
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'active')->count();
        $totalEarnings = Earning::sum('total_amount'); 
        $totalMembers = User::where('role', '!=', 'admin')->count();

        // 2. Fetch Earnings (Money In)
        $earnings = Earning::with('project')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $item->type = 'earning';
                return $item;
            });

        // 3. Fetch Payouts (Money Out) - Only Paid ones
        // Eager load 'earning.project' so we can show the project name
        $payouts = Payout::with(['user', 'earning.project'])
            ->where('is_paid', true)
            ->latest('paid_at')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $item->type = 'payout';
                return $item;
            });

        // 4. Merge & Sort by Date (Most recent first)
        $activities = $earnings->concat($payouts)->sortByDesc(function ($item) {
            return $item->type === 'earning' ? $item->created_at : $item->paid_at;
        })->take(8); // Limit to 8 items in the feed

        return view('livewire.admin.dashboard', [
            'totalProjects' => $totalProjects,
            'activeProjects' => $activeProjects,
            'totalEarnings' => $totalEarnings,
            'totalMembers' => $totalMembers,
            'activities' => $activities, 
        ])->layout('layouts.app', ['title' => 'Admin Dashboard']);
    }
}