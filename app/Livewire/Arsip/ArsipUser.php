<?php

namespace App\Livewire\Arsip;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class ArsipUser extends Component
{
    public function render()
    {
        $userId = Auth::id();

        return view('livewire.arsip.arsip-user', [
            'suratMasuk' => SuratMasuk::where('user_id', $userId)->latest()->get(),
            'suratKeluar' => SuratKeluar::where('user_id', $userId)->latest()->get(),
        ]);
    }
}
