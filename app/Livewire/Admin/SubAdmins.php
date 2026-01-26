<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class SubAdmins extends Component
{
    use WithPagination, AuthorizesRequests;

    public $isModalOpen = false;
    public $sub_admin_id;
    
    // Form Fields
    public $name, $email, $password;
    
    // Permission State
    public $allPermissions = [];
    public $selectedPermissions = []; // Array to store checked boxes

    public function mount()
    {
        // Load all available permissions from DB to show in the form
        $this->allPermissions = Permission::all();
    }

    public function render()
    {
        // List only Sub-Admins
        $roleSubAdmin = config('constant.roles.sub_admin');
        $subAdmins = User::role($roleSubAdmin)->with('roles')->latest()->paginate(10);
        return view('livewire.admin.sub-admins', [
            'subAdmins' => $subAdmins
        ])->layout('layouts.app', ['title' => 'Manage Sub-Admins']);
    }

    public function create()
    {   
        $this->authorize('manage sub_admins');
        $this->reset(['name', 'email', 'password', 'sub_admin_id', 'selectedPermissions']);
        $this->selectedPermissions = []; // Reset checkboxes
        $this->isModalOpen = true;
    }

    public function edit($id)
    {   
        $this->authorize('manage sub_admins');
        $user = User::findOrFail($id);
        $this->sub_admin_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = ''; // Don't show password
        
        // Load their existing permissions into the checkbox array
        // We get names like ['manage users', 'view earnings']
        $this->selectedPermissions = $user->permissions->pluck('name')->toArray();
        
        $this->isModalOpen = true;
    }

    public function save()
    {   
        $this->authorize('manage sub_admins');
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->sub_admin_id,
            'selectedPermissions' => 'array'
        ];

        // Password is required only for new users
        if (!$this->sub_admin_id) {
            $rules['password'] = 'required|min:6';
        }

        $this->validate($rules);

        // 1. Create or Update User
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];
        
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user = User::updateOrCreate(['id' => $this->sub_admin_id], $data);

        // 2. Assign the 'sub_admin' role (Spatie) + Sync 'role' column
        $user->syncRoles(['sub_admin']);
        $user->role = 'sub_admin'; // Update your legacy column
        $user->save();

        // 3. Sync the Specific Permissions (The Magic Part)
        // This gives the user EXACTLY the permissions you checked
        $user->syncPermissions($this->selectedPermissions);

        $this->isModalOpen = false;
        $this->dispatch('notify', message: 'Sub-Admin saved successfully.');
    }
    
    public function closeModal()
    {
        $this->isModalOpen = false;
    }
}