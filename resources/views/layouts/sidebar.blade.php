<aside
  id="sidebar"
  class="fixed inset-y-0 left-0 w-64 bg-white shadow-md p-4 flex flex-col justify-between transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 overflow-y-auto will-change-transform"
  x-data="{ openUser: false }"
>
  <div class="overflow-y-auto">
    <h2 class="text-xl font-bold text-blue-600 mb-6">📨 E-Letter</h2>
    <ul class="space-y-4">
      @if(auth()->user()->hasPermission('view_dashboard'))
        <li>
          <a href="/dashboard" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
            📊 <span>Dashboard</span>
          </a>
        </li>
      @endif

      @if(auth()->user()->hasPermission('manage_letters_in'))
        <li>
          <a href="manajemen-suratmasuk" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
            📥 <span>Surat Masuk</span>
          </a>
        </li>
      @endif

      @if(auth()->user()->hasPermission('manage_letters_out'))
        <li>
          <a href="/surat-keluar" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
            📤 <span>Surat Keluar</span>
          </a>
        </li>
      @endif

      @if(auth()->user()->hasPermission('manage_templates'))
        <li>
          <a href="/template-surat" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
            📑 <span>Template Surat</span>
          </a>
        </li>
      @endif

      @if(auth()->user()->hasPermission('manage_disposition'))
        <li>
          <a href="/disposisi" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
            📝 <span>Disposisi</span>
          </a>
        </li>
      @endif

      @if(auth()->user()->hasPermission('view_reports'))
        <li>
          <a href="/laporan" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
            📈 <span>Laporan</span>
          </a>
        </li>
      @endif

      @if(auth()->user()->hasPermission('manage_settings'))
        <li>
          <a href="/pengaturan" class="flex items-center gap-3 text-gray-700 hover:text-blue-500">
            ⚙️ <span>Pengaturan</span>
          </a>
        </li>
      @endif

      {{-- 🔽 Menu Manajemen User --}}
      @if(auth()->user()->hasPermission('manage_users') || auth()->user()->hasPermission('manage_roles'))
        <li>
          <button
            @click="openUser = !openUser"
            class="flex items-center justify-between w-full text-gray-700 hover:text-blue-500"
          >
            <span class="flex items-center gap-3">
              👥 <span>Manajemen User</span>
            </span>
            <svg
              :class="{ 'rotate-180': openUser }"
              class="w-4 h-4 transform transition-transform duration-300"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <ul
            x-show="openUser"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="mt-2 ml-6 space-y-2 text-sm"
          >
            @if(auth()->user()->hasPermission('manage_roles'))
              <li>
                <a href="/manajemen-role" class="flex items-center gap-2 text-gray-600 hover:text-blue-500">
                  🔑 <span>Role</span>
                </a>
              </li>
            @endif
            @if(auth()->user()->hasPermission('manage_users'))
              <li>
                <a href="/manajemen-user" class="flex items-center gap-2 text-gray-600 hover:text-blue-500">
                  👤 <span>User</span>
                </a>
              </li>
            @endif
          </ul>
        </li>
      @endif

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






































{{-- <aside
  id="sidebar"
  class="fixed inset-y-0 left-0 w-64 bg-white shadow-md p-4 flex flex-col justify-between transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 overflow-y-auto will-change-transform"
  x-data="{ openUser: false }"
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

      <!-- 🔽 Menu Manajemen User dengan submenu -->
      <li>
        <button
          @click="openUser = !openUser"
          class="flex items-center justify-between w-full text-gray-700 hover:text-blue-500"
        >
          <span class="flex items-center gap-3">
            👥 <span>Manajemen User</span>
          </span>
          <svg
            :class="{ 'rotate-180': openUser }"
            class="w-4 h-4 transform transition-transform duration-300"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>

        <ul
          x-show="openUser"
          x-cloak
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform -translate-y-2"
          x-transition:enter-end="opacity-100 transform translate-y-0"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 transform translate-y-0"
          x-transition:leave-end="opacity-0 transform -translate-y-2"
          class="mt-2 ml-6 space-y-2 text-sm"
        >
          <li>
            <a href="/manajemen-role" class="flex items-center gap-2 text-gray-600 hover:text-blue-500">
              🔑 <span>Role</span>
            </a>
          </li>
          <li>
            <a href="/manajemen-user" class="flex items-center gap-2 text-gray-600 hover:text-blue-500">
              👤 <span>User</span>
            </a>
          </li>
        </ul>
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
</aside> --}}
