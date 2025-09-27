<?php

namespace App\Livewire\TamplateSurat;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TemplateSurat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TamplateSuratManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $isEdit = false;
    public $isModalOpen = false;
    public $isMinimized = false;
    public $isFullscreen = false;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $templateId;
    public $nama_template, $kategori, $file_template;
    public $new_file;

    protected $rules = [
        'nama_template' => 'required|string|max:150',
        'kategori' => 'required|in:undangan,peminjaman,sk,lainnya',
        'new_file' => 'nullable|file|mimes:doc,docx,pdf|max:2048',
    ];

    public function render()
    {
        $templates = TemplateSurat::where('nama_template', 'like', "%{$this->search}%")
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.tamplate-surat.tamplate-surat-management', [
            'templates' => $templates
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
            $tpl = TemplateSurat::findOrFail($id);
            $this->templateId = $tpl->id;
            $this->nama_template = $tpl->nama_template;
            $this->kategori = $tpl->kategori;
            $this->file_template = $tpl->file_template;
        }

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->templateId = null;
        $this->nama_template = '';
        $this->kategori = 'lainnya';
        $this->file_template = null;
        $this->new_file = null;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_template' => $this->nama_template,
            'kategori' => $this->kategori,
            'user_id' => Auth::id(),
        ];

        if ($this->new_file) {
            // hapus file lama jika ada
            if ($this->file_template && Storage::disk('public')->exists($this->file_template)) {
                Storage::disk('public')->delete($this->file_template);
            }

            // nama file custom
            $ext = $this->new_file->getClientOriginalExtension();
            $namaFile = Str::slug($this->nama_template . '_' . now()->format('Ymd_His'), '_') . '.' . $ext;

            $data['file_template'] = $this->new_file->storeAs('templates', $namaFile, 'public');
        }

        TemplateSurat::updateOrCreate(['id' => $this->templateId], $data);

        session()->flash('message', $this->templateId ? 'Template berhasil diperbarui.' : 'Template berhasil ditambahkan.');

        $this->closeModal();
        $this->resetForm();
    }

    public function delete($id)
    {
        $tpl = TemplateSurat::findOrFail($id);
        if ($tpl->file_template && Storage::disk('public')->exists($tpl->file_template)) {
            Storage::disk('public')->delete($tpl->file_template);
        }
        $tpl->delete();

        session()->flash('message', 'Template berhasil dihapus.');
    }

    public function generate($id)
    {
        return redirect()->route('template-surat.generate', $id);
    }
    /** Modal controls ala macOS */
    public function minimize() { $this->isMinimized = true; }
    public function restore() { $this->isMinimized = false; }
    public function toggleFullscreen() { $this->isFullscreen = !$this->isFullscreen; }
}
