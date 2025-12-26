<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class Users extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    // Modal State
    public $isModalOpen = false;
    public $isEditMode = false;

    // Form Fields
    public $user_id;
    public $name;
    public $email;
    public $password; // Only required for creation
    public $role = 'member'; // Default to member

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        // 'role' => 'required|in:admin,member',
        'role' => 'required|in:member',
        'password' => 'required|min:6',
    ];

    public function render()
    {   $this->authorize('view users');
        return view('livewire.admin.users', [
            'users' => User::orderBy('created_at', 'desc')->where('role', '!=', 'admin')->paginate(10),
        ])->layout('layouts.app', ['title' => 'User Management']);
    }

    // --- Modal Controls ---
    public function openModal()
    {   
        $this->authorize('create users');
        $this->resetValidation();
        $this->reset(['name', 'email', 'password', 'role', 'user_id', 'isEditMode']);
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    // --- Create / Edit Logic ---
    public function edit($id)
    {   
        $this->authorize('edit users');
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function save()
    {
        if ($this->isEditMode) {
            $this->authorize('edit users');
            // Edit Logic
            $this->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,' . $this->user_id,
                'role' => 'required|in:admin,member',
                'password' => 'nullable|min:6', // Password optional on edit
            ]);

            $user = User::find($this->user_id);
            $user->name = $this->name;
            $user->email = $this->email;
            $user->role = $this->role;
            if ($this->password) {
                $user->password = Hash::make($this->password);
            }
            $user->save();

            session()->flash('message', 'User updated successfully.');

        } else {
            $this->authorize('create users');
            // Create Logic
            $this->validate();

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);

            session()->flash('message', 'User created successfully.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {   
        $this->authorize('delete users');
        // Prevent deleting yourself
        if ($id == auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        User::find($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }
}