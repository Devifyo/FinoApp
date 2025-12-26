<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Project;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Projects extends Component
{
    use WithPagination;

    public $search = '';

    // Reset pagination when searching
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $userId = Auth::id();

        $projects = Project::whereHas('members', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with(['members' => function($q) use ($userId) {
                $q->where('user_id', $userId);
            }])
            ->where('name', 'like', '%' . $this->search . '%') // Basic search capability
            ->latest()
            ->paginate(10);

        return view('livewire.member.projects', [
            'projects' => $projects
        ])->layout('layouts.app', ['title' => 'My Projects']);
    }
}