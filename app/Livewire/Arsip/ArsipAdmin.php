<?php

namespace App\Livewire\Arsip;

use Livewire\Component;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class ArsipAdmin extends Component
{
    public function render()
    {
        return view('livewire.arsip.arsip-admin', [
            'suratMasuk' => SuratMasuk::latest()->get(),
            'suratKeluar' => SuratKeluar::latest()->get(),
        ]);
    }
}
