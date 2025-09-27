<?php

namespace App\Livewire\SuratMasuk;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\SuratMasuk;

class SuratMasukManagement extends Component
{
    use WithPagination, WithFileUploads;

<<<<<<< HEAD
    // Form fields
    public $suratId, $no_surat, $unit_pengirim, $unit_penerima, $perihal, $deskripsi, $tanggal, $tembusan, $file_surat, $existingFile;
=======
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
    public $isEdit = false;
    public $showModal = false;

    // Modal states (macOS style)
    public $isMinimized = false;
    public $isFullscreen = false;

<<<<<<< HEAD
    // Table controls
=======
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
    public $search = '';
    public $perPage = 10;
    public $sortField = 'tanggal';
    public $sortDirection = 'desc';

    protected $rules = [
        'no_surat' => 'required|string|max:100',
        'unit_pengirim' => 'required|string|max:150',
        'unit_penerima' => 'required|string|max:150',
        'perihal' => 'required|string|max:200',
        'deskripsi' => 'nullable|string',
        'tanggal' => 'required|date',
        'tembusan' => 'nullable|string',
        'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ];

    // Reset pagination when search/perPage updated
    public function updatingSearch() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    public function render()
    {
<<<<<<< HEAD
        $query = SuratMasuk::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('no_surat', 'like', '%'.$this->search.'%')
                  ->orWhere('unit_pengirim', 'like', '%'.$this->search.'%')
                  ->orWhere('unit_penerima', 'like', '%'.$this->search.'%')
                  ->orWhere('perihal', 'like', '%'.$this->search.'%');
            });
        }

        $allowedSort = ['no_surat','unit_pengirim','unit_penerima','perihal','tanggal'];
        $sortField = in_array($this->sortField, $allowedSort) ? $this->sortField : 'tanggal';

        $surats = $query->orderBy($sortField, $this->sortDirection)
                        ->paginate($this->perPage);

        return view('livewire.surat-masuk.surat-masuk-management', [
            'surats' => $surats
        ]);
    }
=======
        $surats = SuratMasuk::with(['creator', 'updater', 'creatorRole', 'updaterRole'])
            ->where('no_surat', 'like', "%{$this->search}%")
            ->orWhere('pengirim', 'like', "%{$this->search}%")
            ->orWhere('perihal', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    
        return view('livewire.surat-masuk.surat-masuk-management', ['surats' => $surats]);
    }    
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d

    public function sortBy($field)
    {
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
        $this->resetForm();
        $this->isEdit = $edit;
        $this->isMinimized = false;
        $this->isFullscreen = false;

        if ($edit && $id) {
            $surat = SuratMasuk::findOrFail($id);
            $this->suratId = $surat->id;
            $this->no_surat = $surat->no_surat;
            $this->unit_pengirim = $surat->unit_pengirim;
            $this->unit_penerima = $surat->unit_penerima;
            $this->perihal = $surat->perihal;
            $this->deskripsi = $surat->deskripsi;
            $this->tanggal = $surat->tanggal;
            $this->tembusan = $surat->tembusan;
            $this->existingFile = $surat->file_surat;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetForm()
    {
        $this->suratId = null;
        $this->no_surat = '';
        $this->unit_pengirim = '';
        $this->unit_penerima = '';
        $this->perihal = '';
        $this->deskripsi = '';
        $this->tanggal = '';
        $this->tembusan = '';
        $this->file_surat = null;
        $this->existingFile = null;
        $this->isEdit = false;
    }

    // macOS modal controls
    public function minimize()
    {
        $this->isMinimized = true;
    }

    public function toggleFullscreen()
    {
        $this->isFullscreen = ! $this->isFullscreen;
    }

    public function restore()
    {
        $this->isMinimized = false;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'no_surat' => $this->no_surat,
            'unit_pengirim' => $this->unit_pengirim,
            'unit_penerima' => $this->unit_penerima,
            'perihal' => $this->perihal,
            'deskripsi' => $this->deskripsi,
            'tanggal' => $this->tanggal,
            'tembusan' => $this->tembusan,
            'user_id' => auth()->id(),
        ];

        if ($this->file_surat) {
<<<<<<< HEAD
            $data['file_surat'] = $this->file_surat->store('surat_masuk_files','public');
        } elseif ($this->existingFile) {
            $data['file_surat'] = $this->existingFile;
=======
            // Hapus file lama jika update
            if ($this->suratId) {
                $old = SuratMasuk::find($this->suratId);
                if ($old && $old->file_surat && Storage::disk('public')->exists($old->file_surat)) {
                    Storage::disk('public')->delete($old->file_surat);
                }
            }

            // Buat nama file custom
            $extension = $this->file_surat->getClientOriginalExtension();
            $namaFile = Str::slug($this->no_surat . '_' . $this->tanggal . '_' . $this->pengirim . '_' . $this->perihal, '_') . '.' . $extension;

            // Simpan dengan nama custom
            $data['file_surat'] = $this->file_surat->storeAs('surat_masuk_files', $namaFile, 'public');
        }

        if ($this->suratId) {
            // UPDATE
            $data['updated_by'] = auth()->id();
            $data['updated_role_id'] = auth()->user()->role_id ?? null;
        } else {
            // CREATE
            $data['created_by'] = auth()->id();
            $data['created_role_id'] = auth()->user()->role_id ?? null;
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
        }

        SuratMasuk::updateOrCreate(['id' => $this->suratId], $data);

        session()->flash('message', $this->isEdit ? 'Surat berhasil diperbarui.' : 'Surat berhasil ditambahkan.');
        $this->closeModal();
        $this->resetForm();
    }  

    public function update()
    {
        $this->store(); // Bisa tetap menggunakan store() karena updateOrCreate sudah menangani edit
    }

    public function delete($id)
    {
        SuratMasuk::findOrFail($id)->delete();
        session()->flash('message', 'Surat berhasil dihapus.');
    }

    /**
     * Modal controls (tambahan biar tidak error)
     */
    public function minimize() { $this->isMinimized = true; }
    public function restore() { $this->isMinimized = false; }
    public function toggleFullscreen() { $this->isFullscreen = !$this->isFullscreen; }
}
