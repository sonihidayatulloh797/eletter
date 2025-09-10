<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    use WithPagination;

    public $name, $email, $password, $role, $userId;
    public $isEdit = false;
    public $showModal = false;
    // new
    public $isMinimized = false;
    public $isFullscreen = false;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required'
    ];

    public function render()
    {
        return view('livewire.user-management', [
            'users' => User::with('role')->paginate(10),
            'roles' => Role::all()
        ]);
    }

    public function openModal($edit = false, $id = null)
    {
        $this->resetForm();
        $this->isEdit = $edit;
        $this->isMinimized = false;    // reset ketika membuka modal
        $this->isFullscreen = false;   // reset juga

        if ($edit && $id) {
            $user = User::findOrFail($id);
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role_id; // pastikan field di DB
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->userId = null;
        $this->isEdit = false;
    }

    // new: minimize / restore / fullscreen
    public function minimize()
    {
        $this->isMinimized = true;
    }
    public function toggleFullscreen()
    {
        $this->isFullscreen = ! $this->isFullscreen;
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->role,
        ]);

        session()->flash('success', 'User berhasil ditambahkan!');
        $this->closeModal();
        $this->resetForm();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role,
            'password' => $this->password ? Hash::make($this->password) : $user->password,
        ]);

        session()->flash('success', 'User berhasil diupdate!');
        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('success', 'User berhasil dihapus!');
    }
}
