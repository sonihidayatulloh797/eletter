<?php

namespace App\Livewire\SuratKeluar;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\SuratKeluar;

class SuratKeluarManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $isEdit = false;
    public $showModal = false;

    // Modal states (macOS style)
    public $isMinimized = false;
    public $isFullscreen = false;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'tanggal';
    public $sortDirection = 'desc';

    public $suratId, $no_surat, $tujuan, $perihal, $tanggal, $file_surat;
    public $isModalOpen = false;

    public $template_id;

    protected $rules = [
        'no_surat'   => 'required|string|max:100',
        'tujuan'     => 'required|string|max:150',
        'perihal'    => 'required|string|max:200',
        'tanggal'    => 'required|date',
        'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'template_id' => 'nullable|exists:template_surat,id',
    ];

    public function mount()
    {
        if (!auth()->user()->role->permissions->contains('name', 'manage_letters_out')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
    }

    public function render()
    {
        $surats = SuratKeluar::with(['creator', 'updater', 'creatorRole', 'updaterRole'])
            ->where('no_surat', 'like', "%{$this->search}%")
            ->orWhere('tujuan', 'like', "%{$this->search}%")
            ->orWhere('perihal', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.surat-keluar.surat-keluar-management', [
            'surats' => $surats
        ]);
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
            $surat = SuratKeluar::findOrFail($id);
            $this->suratId = $surat->id;
            $this->no_surat = $surat->no_surat;
            $this->tujuan = $surat->tujuan;
            $this->perihal = $surat->perihal;
            $this->tanggal = $surat->tanggal;
            $this->template_id = $surat->template_id;
        }

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->suratId = null;
        $this->no_surat = '';
        $this->tujuan = '';
        $this->perihal = '';
        $this->tanggal = '';
        $this->file_surat = null;
    }

    public function save()
    {
        $this->validate();
    
        $data = [
            'no_surat' => $this->no_surat,
            'tujuan'   => $this->tujuan,
            'perihal'  => $this->perihal,
            'tanggal'  => $this->tanggal,
            'user_id'  => auth()->id(),
            'template_id' => $this->template_id,
        ];
    
        if ($this->file_surat) {
            // Jika update hapus file lama
            if ($this->suratId) {
                $old = SuratKeluar::find($this->suratId);
                if ($old && $old->file_surat && Storage::disk('public')->exists($old->file_surat)) {
                    Storage::disk('public')->delete($old->file_surat);
                }
            }
    
            // Buat nama file custom berdasarkan field
            $extension = $this->file_surat->getClientOriginalExtension();
            $namaFile = Str::slug($this->no_surat . '_' . $this->tanggal . '_' . $this->tujuan . '_' . $this->perihal, '_') . '.' . $extension;
    
            // Simpan file dengan nama custom
            $data['file_surat'] = $this->file_surat->storeAs('surat_keluar_files', $namaFile, 'public');
        }
    
        if ($this->suratId) {
            // UPDATE
            $data['updated_by'] = auth()->id();
            $data['updated_role_id'] = auth()->user()->role_id ?? null;
        } else {
            // CREATE
            $data['created_by'] = auth()->id();
            $data['created_role_id'] = auth()->user()->role_id ?? null;
        }
    
        SuratKeluar::updateOrCreate(['id' => $this->suratId], $data);
    
        session()->flash('message', $this->suratId ? 'Surat keluar berhasil diperbarui.' : 'Surat keluar berhasil ditambahkan.');
    
        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        SuratKeluar::findOrFail($id)->delete();
        session()->flash('message', 'Surat keluar berhasil dihapus.');
    }

    /**
     * Modal controls (tambahan biar tidak error)
     */
    public function minimize() { $this->isMinimized = true; }
    public function restore() { $this->isMinimized = false; }
    public function toggleFullscreen() { $this->isFullscreen = !$this->isFullscreen; }
}
