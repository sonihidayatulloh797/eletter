<?php

namespace App\Livewire\Laporan;

use Livewire\Component;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class LaporanManagement extends Component
{
    public $totalSuratMasuk;
    public $totalSuratKeluar;

    public function mount()
    {
        $this->totalSuratMasuk = SuratMasuk::count();
        $this->totalSuratKeluar = SuratKeluar::count();
    }

    public function render()
    {
        return view('livewire.laporan.laporan-management');
    }
}
