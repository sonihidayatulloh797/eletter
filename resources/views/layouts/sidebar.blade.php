<aside
  id="sidebar"
  class="fixed inset-y-0 left-0 w-64 bg-white shadow-md p-4 flex flex-col justify-between transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50"
>
  <div class="overflow-y-auto">
    <h2 class="text-xl font-bold text-blue-600 mb-6">📨 E-Letter</h2>
    <ul class="space-y-4">
      <li>
        <a href="/dashboard" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
          📊 <span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="/surat-masuk" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
          📥 <span>Surat Masuk</span>
        </a>
      </li>
      <li>
        <a href="/surat-keluar" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
          📤 <span>Surat Keluar</span>
        </a>
      </li>
      <li>
        <a href="/template-surat" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
          📑 <span>Template Surat</span>
        </a>
      </li>
      <li>
        <a href="/disposisi" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
          📝 <span>Disposisi</span>
        </a>
      </li>
      <li>
        <a href="/laporan" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
          📈 <span>Laporan</span>
        </a>
      </li>
      <li>
        <a href="/pengaturan" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
          ⚙️ <span>Pengaturan</span>
        </a>
      </li>

      {{-- 🔽 Tambahan Menu User Management --}}
      <li>
        <a href="/manajemen-user" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
          👥 <span>Manajemen User</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="flex items-center gap-3 mt-6">
    <img src="https://i.pravatar.cc/40" alt="user" class="w-10 h-10 rounded-full"/>
    <div>
      <p class="font-semibold">{{ auth()->user()->name }}</p>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-sm text-red-500 hover:underline">
          Logout
        </button>
      </form>
    </div>
  </div>
</aside>
