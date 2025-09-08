<x-layouts.app>
    <!-- Top Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
      <div class="bg-purple-500 text-white rounded-2xl p-6 shadow-lg">
        <p class="text-sm">Surat Masuk</p>
        <p class="text-3xl font-bold">120</p>
      </div>
      <div class="bg-cyan-500 text-white rounded-2xl p-6 shadow-lg">
        <p class="text-sm">Surat Keluar</p>
        <p class="text-3xl font-bold">85</p>
      </div>
      <div class="bg-blue-500 text-white rounded-2xl p-6 shadow-lg">
        <p class="text-sm">Disposisi</p>
        <p class="text-3xl font-bold">40</p>
      </div>
    </div>
  
    <!-- Middle Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
      <div class="lg:col-span-2 bg-white p-4 rounded-2xl shadow-md">
        <p class="font-semibold mb-2">📊 Statistik Surat Bulanan</p>
        <div class="h-64">
          <canvas id="barChart"></canvas>
        </div>
      </div>
      <div class="bg-white p-4 rounded-2xl shadow-md">
        <p class="font-semibold mb-2">🥧 Distribusi Surat</p>
        <div class="h-64">
          <canvas id="pieChart"></canvas>
        </div>
      </div>
    </div>
  
    <!-- Table Surat Terbaru -->
    <div class="bg-white p-4 rounded-2xl shadow-md">
      <p class="font-semibold mb-3">📥 Surat Masuk Terbaru</p>
      <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
          <thead class="text-gray-500 border-b">
            <tr>
              <th class="text-left p-2">No Surat</th>
              <th class="text-left p-2">Pengirim</th>
              <th class="text-left p-2">Perihal</th>
              <th class="text-left p-2">Tanggal</th>
            </tr>
          </thead>
          <tbody class="text-gray-700">
            <tr class="border-b"><td class="p-2">001/UNIV/2024</td><td>Fakultas Teknik</td><td>Undangan Rapat</td><td>01-09-2024</td></tr>
            <tr class="border-b"><td class="p-2">002/UNIV/2024</td><td>Rektorat</td><td>Pengumuman Libur</td><td>05-09-2024</td></tr>
            <tr><td class="p-2">003/UNIV/2024</td><td>Fakultas Hukum</td><td>Permohonan Data</td><td>07-09-2024</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </x-layouts.app>
  