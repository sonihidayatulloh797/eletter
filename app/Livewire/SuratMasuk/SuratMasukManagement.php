<?php

namespace App\Livewire\SuratMasuk;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\SuratMasuk;

class SuratMasukManagement extends Component
{
    use WithPagination, WithFileUploads;

    // Form fields
    public $suratId, $no_surat, $unit_pengirim, $unit_penerima, $perihal, $deskripsi, $tanggal, $tembusan, $file_surat, $existingFile;
    public $isEdit = false;
    public $showModal = false;

    // Modal states (macOS style)
    public $isMinimized = false;
    public $isFullscreen = false;

    // Table controls
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
            $data['file_surat'] = $this->file_surat->store('surat_masuk_files','public');
        } elseif ($this->existingFile) {
            $data['file_surat'] = $this->existingFile;
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
}
