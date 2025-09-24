<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

  <title>E-Letter Dashboard</title>

  {{-- Tailwind via CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Chart.js (biar dipakai di child view) --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @livewireStyles
</head>
<body class="bg-gray-100 font-sans">
  <!-- <div class="min-h-screen flex"> -->

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Overlay (mobile) --}}
    <div id="overlay" class="fixed inset-0 bg-black/50 hidden md:hidden z-40"></div>

    {{-- Main Content --}}
    <div class="flex-1 md:ml-64 p-4 md:p-6">
      {{-- Navbar --}}
      <div class="flex items-center justify-between bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex items-center gap-3">
          {{-- Burger button hanya tampil di mobile --}}
          <button id="menuBtn" class="md:hidden p-2 rounded-lg bg-blue-500 text-white focus:outline-none focus:ring">
            ☰
          </button>
          <h1 class="text-xl font-bold">E-Letter UNLA</h1>
        </div>

        <div class="flex items-center gap-4" x-data="{ notifOpen: false, userOpen: false }">
          
          {{-- Notifikasi --}}
          <div class="relative">
            <button @click="notifOpen = !notifOpen" class="p-2 bg-gray-200 rounded-full relative focus:ring">
              🔔
              <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">3</span>
            </button>

            {{-- Dropdown Notifikasi --}}
            <div x-show="notifOpen" @click.outside="notifOpen = false"
                class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden z-50">
              <div class="p-3 border-b text-sm font-semibold text-gray-700">Notifikasi</div>
              <ul class="max-h-60 overflow-y-auto text-sm">
                <li class="px-4 py-2 hover:bg-gray-50">📄 Surat masuk baru dari Rektor</li>
                <li class="px-4 py-2 hover:bg-gray-50">✅ Disposisi berhasil ditambahkan</li>
                <li class="px-4 py-2 hover:bg-gray-50">⚠️ File surat perlu diperiksa</li>
              </ul>
              <div class="p-2 text-center border-t text-xs text-blue-600 hover:bg-gray-50 cursor-pointer">
                Lihat semua
              </div>
            </div>
          </div>

          {{-- User Profile --}}
          <div class="relative">
            <button @click="userOpen = !userOpen" class="p-2 bg-gray-200 rounded-full focus:ring">
              {{-- SVG User --}}
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5Zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5Z"/>
              </svg>
            </button>

            {{-- Dropdown User --}}
            <div x-show="userOpen" @click.outside="userOpen = false"
                class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
              <div class="p-3 border-b text-sm font-semibold text-gray-700">Halo, Admin</div>
              <ul class="text-sm">
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-50">⚙️ Pengaturan</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 hover:bg-gray-50">📂 Arsip Saya</a>
                </li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-50">🚪 Logout</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>

      {{-- Slot konten (isi dari child view) --}}
      {{ $slot }}
    </div>

  @livewireScripts
  @stack('scripts')

  <script>
    // Toggle sidebar di mobile
    const menuBtn  = document.getElementById('menuBtn');
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('overlay');

    function openSidebar() {
      sidebar.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
    }
    function closeSidebar() {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    }

    menuBtn?.addEventListener('click', () => {
      if (sidebar.classList.contains('-translate-x-full')) {
        openSidebar();
      } else {
        closeSidebar();
      }
    });

    overlay?.addEventListener('click', closeSidebar);

    // Tutup sidebar saat resize ke desktop agar sinkron
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 768) {
        sidebar.classList.remove('-translate-x-full'); // tampil di md+
        overlay.classList.add('hidden');
      } else {
        sidebar.classList.add('-translate-x-full'); // sembunyi di < md
      }
    });
  </script>
</body>
</html>
