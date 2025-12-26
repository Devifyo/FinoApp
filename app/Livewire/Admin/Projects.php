<?php

namespace App\Livewire\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectMember;
use App\Models\Setting;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Projects extends Component
{
    use WithPagination, AuthorizesRequests;

    // UI State
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    public $isEditMode = false;
    public $deleteId = null;

    // Project Form Data
    public $project_id;
    public $name;
    public $client_name;
    public $platform = 'Upwork';
    public $start_date; // <--- ADDED THIS
    public $status = 'active';

    // Team Data
    public $assigned_members = []; 
    public $users = [];
    public $settings = [];

    protected $rules = [
        'name' => 'required|min:3',
        'client_name' => 'nullable|string',
        'platform' => 'required',
        'start_date' => 'nullable|date', // <--- ADDED VALIDATION
        'status' => 'required|in:active,completed,hold',
        'assigned_members' => 'required|array|min:1', 
        'assigned_members.*.user_id' => 'required|exists:users,id',
        'assigned_members.*.role' => 'required',
        'assigned_members.*.contribution_share' => 'nullable|numeric|min:0|max:100',
    ];

    public function mount()
    {
        $this->users = User::where('role', '!=', User::ROLE_ADMIN)
                       ->orderBy('name')
                       ->get();
        $this->settings = Setting::pluck('value', 'key')->toArray();
    }

    public function updated($property, $value)
    {
        if (str_contains($property, '.role')) {
            $parts = explode('.', $property);
            $index = $parts[1];
            $role = $value;
            $share = 0;

            switch ($role) {
                case 'bidder':    $share = $this->settings['default_bidder_percentage'] ?? 30; break;
                case 'developer': $share = $this->settings['default_developer_percentage'] ?? 60; break;
                case 'idle':      $share = $this->settings['default_idle_percentage'] ?? 10; break;
                case 'solo':      $share = $this->settings['solo_developer_percentage'] ?? 80; break;
            }

            $this->assigned_members[$index]['contribution_share'] = (float) $share;
        }
    }

    public function addMember()
    {
        $this->assigned_members[] = [
            'user_id' => '',
            'role' => 'developer',
            'is_main_developer' => false,
            'contribution_share' => (float) ($this->settings['default_developer_percentage'] ?? 60),
        ];
    }

    public function removeMember($index)
    {
        unset($this->assigned_members[$index]);
        $this->assigned_members = array_values($this->assigned_members);
    }

    public function openModal()
    {   
        $this->authorize('create projects');
        $this->resetValidation();
        // ADDED 'start_date' to reset list
        $this->reset(['name', 'client_name', 'platform', 'start_date', 'status', 'project_id', 'isEditMode']);
        $this->assigned_members = [];
        $this->addMember();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isDeleteModalOpen = false;
    }

    public function edit($id)
    {   
        $this->authorize('edit projects');
        $project = Project::with('members')->findOrFail($id);
        $this->project_id = $id;
        $this->name = $project->name;
        $this->client_name = $project->client_name;
        $this->platform = $project->platform;
        $this->start_date = $project->start_date; // <--- LOAD START DATE
        $this->status = $project->status;
        // dd($this->start_date);
        $this->assigned_members = $project->members->map(function($m) {
            return [
                'user_id' => $m->user_id,
                'role' => $m->role,
                'is_main_developer' => (bool) $m->is_main_developer,
                'contribution_share' => (float) $m->contribution_share,
            ];
        })->toArray();

        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function save()
    {   
        if ($this->project_id) {
            $this->authorize('edit projects');
        } else {
            $this->authorize('create projects');
        }
        $this->validate();

        DB::transaction(function () {
            $project = Project::updateOrCreate(
                ['id' => $this->project_id],
                [
                    'name' => $this->name,
                    'client_name' => $this->client_name,
                    'platform' => $this->platform,
                    'start_date' => $this->start_date, // <--- SAVE START DATE
                    'status' => $this->status,
                ]
            );

            $project->members()->delete();

            foreach ($this->assigned_members as $row) {
                ProjectMember::create([
                    'project_id' => $project->id,
                    'user_id' => $row['user_id'],
                    'role' => $row['role'],
                    'is_main_developer' => $row['is_main_developer'] ?? false,
                    'contribution_share' => $row['contribution_share'] ?? 0,
                ]);
            }
        });

        $this->dispatch('notify', message: $this->isEditMode ? 'Project updated successfully.' : 'Project created successfully.');
        $this->closeModal();
    }

    public function confirmDelete($id)
    {   
        $this->authorize('delete projects');
        $this->deleteId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {   
        $this->authorize('delete projects');
        if ($this->deleteId) {
            Project::find($this->deleteId)->delete();
            $this->dispatch('notify', message: 'Project deleted successfully.', type: 'error');
        }
        $this->closeModal();
    }

    public function render()
    {   
        $this->authorize('view projects');
        return view('livewire.admin.projects', [
            'projects' => Project::with('members.user')->withSum('earnings', 'total_amount')->latest()->paginate(9)
        ])->layout('layouts.app', ['title' => 'Project Management']);
    }
}