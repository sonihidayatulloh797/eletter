<?php

namespace App\Livewire\Disposisi;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;

class DisposisiManagement extends Component
{
    use WithPagination;

    public $suratMasukId;
    public $disposisiId;
    public $user_id, $catatan, $status;
    public $isModalOpen = false;

    // Modal states (macOS style)
    public $isMinimized = false;
    public $isFullscreen = false;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'catatan' => 'nullable|string',
        'status'  => 'required|in:belum_dibaca,dibaca,ditindaklanjuti',
    ];

    public function mount($suratMasukId = null)
    {
        $this->suratMasukId = $suratMasukId;
    }

    public function render()
    {
        if (!$this->suratMasukId) {
            $disposisis = Disposisi::whereRaw('0=1')->paginate($this->perPage);
            return view('livewire.disposisi.disposisi-management', [
                'disposisis' => $disposisis,
                'users' => User::all(),
                'surat' => null,
            ]);
        }

        $query = Disposisi::with('user')
            ->where('surat_masuk_id', $this->suratMasukId);

        if (!empty($this->search)) {
            $s = "%{$this->search}%";
            $query->where(function ($q) use ($s) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', $s))
                  ->orWhere('catatan', 'like', $s)
                  ->orWhere('status', 'like', $s);
            });
        }

        $disposisis = $query
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.disposisi.disposisi-management', [
            'disposisis' => $disposisis,
            'users'      => User::all(),
            'surat'      => SuratMasuk::find($this->suratMasukId),
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openModal($id = null)
    {
        $this->resetForm();

        if ($id) {
            $d = Disposisi::findOrFail($id);
            $this->disposisiId = $d->id;
            $this->user_id     = $d->user_id;
            $this->catatan     = $d->catatan;
            $this->status      = $d->status;
        }

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->disposisiId = null;
        $this->user_id     = '';
        $this->catatan     = '';
        $this->status      = 'belum_dibaca';
    }

    public function save()
    {
        $this->validate();

        Disposisi::updateOrCreate(
            ['id' => $this->disposisiId],
            [
                'surat_masuk_id' => $this->suratMasukId,
                'user_id'        => $this->user_id,
                'catatan'        => $this->catatan,
                'status'         => $this->status,
            ]
        );

        session()->flash('message', $this->disposisiId ? 'Disposisi berhasil diperbarui.' : 'Disposisi berhasil ditambahkan.');

        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        Disposisi::findOrFail($id)->delete();
        session()->flash('message', 'Disposisi berhasil dihapus.');
    }

    // Modal macOS style
    public function minimize() { $this->isMinimized = true; }
    public function restore() { $this->isMinimized = false; }
    public function toggleFullscreen() { $this->isFullscreen = !$this->isFullscreen; }
}
