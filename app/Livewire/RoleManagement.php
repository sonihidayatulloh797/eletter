<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleManagement extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Form fields
    public $name, $description, $roleId;
    public $isEdit = false;
    public $showModal = false;

    // Modal states (macOS style)
    public $isMinimized = false;
    public $isFullscreen = false;

    // Table controls
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $rules = [
        'name' => 'required|min:3|unique:roles,name',
        'description' => 'nullable|string|max:255',
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    // Render dengan permission check
    public function render()
    {
        $this->authorizePermission('manage_users');

        $query = Role::query();

        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%');
        }

        $allowedSort = ['name', 'description', 'created_at'];
        $sortField = in_array($this->sortField, $allowedSort) ? $this->sortField : 'name';

        $roles = $query->orderBy($sortField, $this->sortDirection)
                       ->paginate($this->perPage);

        return view('livewire.role-management', ['roles' => $roles]);
    }

    public function sortBy($field)
    {
        $this->authorizePermission('manage_users');

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function openModal($edit = false, $id = null)
    {
        $this->authorizePermission('manage_users');

        $this->resetForm();
        $this->isEdit = $edit;
        $this->isMinimized = false;
        $this->isFullscreen = false;

        if ($edit && $id) {
            $role = Role::findOrFail($id);
            $this->roleId = $role->id;
            $this->name = $role->name;
            $this->description = $role->description;
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
        $this->description = '';
        $this->roleId = null;
        $this->isEdit = false;
    }

    // Modal controls
    public function minimize() { $this->isMinimized = true; }
    public function restore() { $this->isMinimized = false; }
    public function toggleFullscreen() { $this->isFullscreen = !$this->isFullscreen; }

    // CRUD dengan permission check
    public function store()
    {
        $this->authorizePermission('manage_users');

        $this->validate();

        Role::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Role berhasil ditambahkan!');
        $this->closeModal();
        $this->resetForm();
    }

    public function update()
    {
        $this->authorizePermission('manage_users');

        $this->validate([
            'name' => 'required|min:3|unique:roles,name,' . $this->roleId,
            'description' => 'nullable|string|max:255',
        ]);

        $role = Role::findOrFail($this->roleId);
        $role->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Role berhasil diupdate!');
        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        $this->authorizePermission('manage_users');

        Role::findOrFail($id)->delete();
        session()->flash('success', 'Role berhasil dihapus!');
        $this->resetPage();
    }

    /**
     * Helper: Cek permission user
     */
    private function authorizePermission($permissionName)
    {
        $user = Auth::user();
        if (!$user || !$user->hasPermission($permissionName)) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }
    }
}
