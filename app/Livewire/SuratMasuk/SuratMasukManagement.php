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

    // Form fields (aku tetap simpan variabel lama juga supaya kode kamu nggak "hilang")
    public $suratId, $no_surat, $unit_pengirim, $unit_penerima, $perihal, $deskripsi, $tembusan, $tanggal, $file_surat, $existingFile, $pengirim;

    // UI states (sediakan BOTH nama agar kompatibel)
    public $isEdit = false;
    public $showModal = false;      // nama lama yang kamu gunakan sebelumnya
    public $isModalOpen = false;    // nama yang dipakai Blade sekarang
    public $isMinimized = false;
    public $isFullscreen = false;

    // Table controls
    public $search = '';
    public $perPage = 10;
    public $sortField = 'tanggal';
    public $sortDirection = 'desc';

    // Disposisi
    public $isDisposisiOpen = false;
    public $isDisposisiFullscreen = false;
    public $isDisposisiMinimized = false;
    public $selectedSuratId = null;
    
    public function openDisposisi($suratId)
    {
        $this->selectedSuratId = $suratId;
        $this->isDisposisiOpen = true;
    }
    
    public function closeDisposisi()
    {
        $this->isDisposisiOpen = false;
        $this->selectedSuratId = null;
        $this->isDisposisiFullscreen = false;
        $this->isDisposisiMinimized = false;
    }
    
    public function minimizeDisposisi()
    {
        $this->isDisposisiMinimized = true;
    }
    
    public function restoreDisposisi()
    {
        $this->isDisposisiMinimized = false;
    }
    
    public function toggleDisposisiFullscreen()
    {
        $this->isDisposisiFullscreen = !$this->isDisposisiFullscreen;
    }    

    protected $rules = [
        'no_surat'   => 'required|string|max:100',
        'pengirim'   => 'required|string|max:150',
        'perihal'    => 'required|string|max:200',
        'tanggal'    => 'required|date',
        'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    public function render()
    {
        $query = SuratMasuk::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('no_surat', 'like', '%'.$this->search.'%')
                  ->orWhere('pengirim', 'like', '%'.$this->search.'%')
                  ->orWhere('perihal', 'like', '%'.$this->search.'%');
            });
        }

        $allowedSort = ['no_surat','pengirim','perihal','tanggal'];
        $sortField = in_array($this->sortField, $allowedSort) ? $this->sortField : 'tanggal';

        $surats = $query->orderBy($sortField, $this->sortDirection)
                        ->paginate($this->perPage);

        return view('livewire.surat-masuk.surat-masuk-management', [
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
        $this->resetPage();
    }

    /**
     * Open modal.
     * Parameter $id = null -> create mode; $id = number -> edit mode
     */
    public function openModal($id = null)
    {
        $this->resetForm();
        $this->isEdit = $id ? true : false;
        $this->suratId = $id;

        if ($id) {
            $surat = SuratMasuk::findOrFail($id);
            $this->no_surat      = $surat->no_surat;
            // legacy props left intact
            $this->unit_pengirim = $surat->pengirim ?? '';
            $this->pengirim      = $surat->pengirim ?? '';
            $this->unit_penerima = null;
            $this->perihal       = $surat->perihal;
            $this->deskripsi     = null;
            $this->tembusan      = null;
            $this->tanggal       = $surat->tanggal;
            $this->existingFile  = $surat->file_surat;
        }

        // keep both flags in sync
        $this->showModal = $this->isModalOpen = true;
        $this->isMinimized = false;
        $this->isFullscreen = false;
    }

    public function closeModal()
    {
        $this->showModal = $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->suratId = null;
        $this->no_surat = '';
        $this->unit_pengirim = '';
        $this->unit_penerima = '';
        $this->perihal = '';
        $this->deskripsi = '';
        $this->tembusan = '';
        $this->tanggal = '';
        $this->file_surat = null;
        $this->existingFile = null;
        $this->pengirim = '';
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'no_surat'        => $this->no_surat,
            'pengirim'        => $this->pengirim,
            'perihal'         => $this->perihal,
            'tanggal'         => $this->tanggal,
            'user_id'         => auth()->id(),
            'updated_by'      => auth()->id(),
            'updated_role_id' => auth()->user()->role_id ?? null,
        ];

        if ($this->file_surat) {
            if ($this->suratId) {
                $old = SuratMasuk::find($this->suratId);
                if ($old && $old->file_surat && Storage::disk('public')->exists($old->file_surat)) {
                    Storage::disk('public')->delete($old->file_surat);
                }
            }

            $extension = $this->file_surat->getClientOriginalExtension();
            $namaFile = Str::slug($this->no_surat . '_' . $this->tanggal . '_' . $this->pengirim . '_' . $this->perihal, '_') . '.' . $extension;

            $data['file_surat'] = $this->file_surat->storeAs('surat_masuk_files', $namaFile, 'public');
        } elseif ($this->existingFile) {
            $data['file_surat'] = $this->existingFile;
        }

        if ($this->suratId) {
            SuratMasuk::find($this->suratId)->update($data);
            session()->flash('message', 'Surat berhasil diperbarui.');
        } else {
            $data['created_by'] = auth()->id();
            $data['created_role_id'] = auth()->user()->role_id ?? null;

            SuratMasuk::create($data);
            session()->flash('message', 'Surat berhasil ditambahkan.');
        }

        $this->closeModal();
        $this->resetForm();
    }

    public function update()
    {
        // tetap sediakan jika ada kode lain memanggil update()
        $this->store();
    }

    public function delete($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            Storage::disk('public')->delete($surat->file_surat);
        }

        $surat->delete();
        session()->flash('message', 'Surat berhasil dihapus.');
    }

    // Modal controls
    public function minimize() { $this->isMinimized = true; }
    public function restore() { $this->isMinimized = false; }
    public function toggleFullscreen() { $this->isFullscreen = !$this->isFullscreen; }
}
