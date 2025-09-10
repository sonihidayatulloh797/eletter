<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>E-Letter Dashboard</title>

  {{-- Tailwind via CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Chart.js (biar dipakai di child view) --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @livewireStyles
</head>
<body class="bg-gray-100 font-sans overflow-x-hidden">
  <div class="min-h-screen flex">

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
          <h1 class="text-xl font-bold">E-Letter UNLAs</h1>
        </div>
        <div class="flex items-center gap-4">
          <button class="p-2 bg-gray-200 rounded-full">🔔</button>
          <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full"/>
        </div>
      </div>

      {{-- Slot konten (isi dari child view) --}}
      {{ $slot }}
    </div>
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
