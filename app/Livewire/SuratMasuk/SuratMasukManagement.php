<?php

namespace App\Livewire\SuratMasuk;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\SuratMasuk;

class SuratMasukManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortField = 'tanggal';
    public $sortDirection = 'desc';

    public $suratId, $no_surat, $pengirim, $perihal, $tanggal, $file_surat;
    public $isModalOpen = false;

    protected $rules = [
        'no_surat' => 'required|string|max:100',
        'pengirim' => 'required|string|max:150',
        'perihal' => 'required|string|max:200',
        'tanggal' => 'required|date',
        'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ];

    public function mount()
    {
        if (!auth()->user()->role->permissions->contains('name', 'manage_letters_in')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
    }

    public function render()
    {
        $surats = SuratMasuk::where('no_surat', 'like', "%{$this->search}%")
            ->orWhere('pengirim', 'like', "%{$this->search}%")
            ->orWhere('perihal', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.surat-masuk.surat-masuk-management', ['surats' => $surats]);
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
            $surat = SuratMasuk::findOrFail($id);
            $this->suratId = $surat->id;
            $this->no_surat = $surat->no_surat;
            $this->pengirim = $surat->pengirim;
            $this->perihal = $surat->perihal;
            $this->tanggal = $surat->tanggal;
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
        $this->pengirim = '';
        $this->perihal = '';
        $this->tanggal = '';
        $this->file_surat = null;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'no_surat' => $this->no_surat,
            'pengirim' => $this->pengirim,
            'perihal' => $this->perihal,
            'tanggal' => $this->tanggal,
            'user_id' => auth()->id(),
        ];

        if ($this->file_surat) {
            $data['file_surat'] = $this->file_surat->store('surat_masuk_files', 'public');
        }

        SuratMasuk::updateOrCreate(['id' => $this->suratId], $data);

        session()->flash('message', $this->suratId ? 'Surat berhasil diperbarui.' : 'Surat berhasil ditambahkan.');

        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        SuratMasuk::findOrFail($id)->delete();
        session()->flash('message', 'Surat berhasil dihapus.');
    }
}
