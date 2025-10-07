<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;

class Dashboard extends Component
{
    // 🔹 Properti untuk menampung data ringkasan
    public $jumlahSuratMasuk = 0;
    public $jumlahSuratKeluar = 0;
    public $jumlahDisposisi = 0;

    // 🔹 Data untuk chart
    public $chartData = [];
    public $chartLabels = [];

    // 🔹 Data untuk distribusi surat
    public $distribusiData = [];

    // 🔹 Data surat terbaru
    public $suratTerbaru = [];

    /**
     * Lifecycle mount — dijalankan saat komponen pertama kali dimuat
     */
    public function mount()
    {
        // 🔸 Hitung jumlah surat masuk, keluar, dan disposisi
        $this->jumlahSuratMasuk = SuratMasuk::count();
        $this->jumlahSuratKeluar = SuratKeluar::count();
        $this->jumlahDisposisi = Disposisi::count();

        // 🔸 Ambil data untuk statistik surat masuk bulanan (bar chart)
        $dataBulanan = DB::table('surat_masuk')
            ->select(
                DB::raw('MONTH(tanggal) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // 🔸 Konversi hasil query ke format chart
        $this->chartLabels = [];
        $this->chartData = [];

        // 🔸 Daftar nama bulan Bahasa Indonesia (jika ingin tampil lebih familiar)
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        foreach ($dataBulanan as $item) {
            // Pastikan nama bulan ada di array
            $bulanNama = $namaBulan[$item->bulan] ?? 'Tidak Diketahui';
            $this->chartLabels[] = $bulanNama;
            $this->chartData[] = $item->total;
        }

        // 🔸 Jika tidak ada data sama sekali, tambahkan data default agar Chart.js tetap bisa render
        if (empty($this->chartLabels) || empty($this->chartData)) {
            $this->chartLabels = ['Tidak Ada Data'];
            $this->chartData = [0];
        }

        // 🔸 Data distribusi surat (pie chart)
        $this->distribusiData = [
            'Masuk' => $this->jumlahSuratMasuk,
            'Keluar' => $this->jumlahSuratKeluar,
            'Disposisi' => $this->jumlahDisposisi,
        ];

        // 🔸 Surat masuk terbaru
        $this->suratTerbaru = SuratMasuk::orderBy('tanggal', 'desc')
            ->take(5)
            ->get(['no_surat', 'pengirim', 'perihal', 'tanggal']);
    }

    /**
     * Render view dashboard dengan data dinamis
     */
    public function render()
    {
        // Pastikan semua variabel selalu ada untuk menghindari error undefined key
        $chartLabels = $this->chartLabels ?? [];
        $chartData = $this->chartData ?? [];
        $distribusiData = $this->distribusiData ?? [
            'Masuk' => 0,
            'Keluar' => 0,
            'Disposisi' => 0,
        ];

        return view('livewire.dashboard.dashboard', [
            'jumlahSuratMasuk' => $this->jumlahSuratMasuk,
            'jumlahSuratKeluar' => $this->jumlahSuratKeluar,
            'jumlahDisposisi' => $this->jumlahDisposisi,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'distribusiData' => $distribusiData,
            'suratTerbaru' => $this->suratTerbaru,
        ]);
    }
}
