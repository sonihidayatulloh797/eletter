<div class="p-4 sm:p-6 bg-gray-100 min-h-screen">
    <h2 class="text-lg sm:text-xl font-bold mb-6 text-gray-800">👥 Manajemen User</h2>

    @if (session()->has('success'))
    <div
        class="bg-green-50 text-green-700 px-4 py-2 rounded-2xl mb-4 shadow-sm border border-green-200 text-sm sm:text-base">
        ✅ {{ session('success') }}
    </div>
    @endif

    <!-- Tombol Tambah -->
    <button wire:click="openModal(false)"
        class="bg-gradient-to-r from-blue-400 to-blue-500 text-white px-4 py-2 rounded-xl mb-5 text-sm sm:text-base shadow hover:from-blue-500 hover:to-blue-600 transition-all duration-200">
        + Tambah User
    </button>

    <!-- Card Table User -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
    <!-- Search -->
    <input type="text" wire:model.live="search"
           placeholder="🔍 Cari user..."
           class="w-full sm:w-64 border rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">

    <!-- Filter Role -->
    <select wire:model.live="filterRole"
            class="border rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
        <option value="">-- Semua Role --</option>
        @foreach ($roles as $r)
            <option value="{{ $r->id }}">{{ $r->name }}</option>
        @endforeach
    </select>

    <!-- Per page -->
    <select wire:model.live="perPage"
                class="border rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
            <option value="10">10 / halaman</option>
            <option value="25">25 / halaman</option>
            <option value="50">50 / halaman</option>
            <option value="100">100 / halaman</option>
        </select>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white/80 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200">
        <table class="w-full text-xs sm:text-sm">
            <thead class="text-gray-600 border-b bg-gray-50/70">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left cursor-pointer" wire:click="sortBy('name')">
                        Nama {!! $sortField === 'name' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left hidden sm:table-cell cursor-pointer" wire:click="sortBy('email')">
                        Email {!! $sortField === 'email' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left">Role</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($users as $index => $user)
                    <tr class="border-b hover:bg-gray-50/70 transition">
                        <td class="p-3">
                            {{ $users->firstItem() + $index }}
                        </td>
                        <td class="p-3 font-medium">{{ $user->name }}</td>
                        <td class="p-3 hidden sm:table-cell">{{ $user->email }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded-full text-xs
                                {{ ($user->role?->name ?? '-') === 'Admin' ? 'bg-red-100 text-red-700' :
                                (($user->role?->name ?? '-') === 'User' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ $user->role?->name ?? '-' }}
                            </span>
                        </td>
                        <td class="p-3 flex gap-2">
                            <button wire:click="openModal(true, {{ $user->id }})"
                                class="px-3 py-1 rounded-xl text-xs bg-yellow-400 text-white shadow hover:bg-yellow-500">
                                ✏️ Edit
                            </button>
                            <button wire:click="delete({{ $user->id }})"
                                class="px-3 py-1 rounded-xl text-xs bg-red-500 text-white shadow hover:bg-red-600"
                                onclick="return confirm('Yakin hapus user ini?')">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">
                            🙅 Belum ada data user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>


    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50 px-4">
            {{-- MINIMIZED BAR --}}
            @if($isMinimized)
                <div class="fixed bottom-6 left-6 z-50">
                    <div
                        class="flex items-center gap-3 bg-white/90 backdrop-blur-md rounded-full px-3 py-2 shadow-lg border border-gray-200 cursor-pointer"
                        wire:click="restore"
                        role="button"
                        aria-label="Restore window">
                        <div class="flex items-center gap-2">
                            <button wire:click.stop="closeModal" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600" aria-label="Close"></button>
                            <button wire:click.stop="restore" class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500" aria-label="Restore"></button>
                            <button wire:click.stop="toggleFullscreen" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600" aria-label="Toggle fullscreen"></button>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-800">
                            {{ $isEdit ? '✏️ Edit User' : '➕ Tambah User' }}
                        </span>
                    </div>
                </div>
            @else
                {{-- NORMAL / FULLSCREEN MODAL --}}
                <div
                    class="@if($isFullscreen) w-full max-w-none h-[90vh] max-h-[90vh] rounded-xl @else w-full max-w-lg rounded-3xl @endif
                        bg-white/95 backdrop-blur-xl shadow-2xl border border-gray-200 overflow-hidden transition-all duration-200">
                    <!-- Header ala macOS -->
                    <div class="flex items-center justify-between px-3 py-2 bg-gray-50 border-b">
                        <div class="flex items-center space-x-2">
                            <button wire:click="closeModal" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600" aria-label="Close"></button>
                            <button wire:click="minimize" class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500" aria-label="Minimize"></button>
                            <button wire:click="toggleFullscreen" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600" aria-label="Toggle fullscreen"></button>
                        </div>

                        <h3 class="text-sm sm:text-base font-semibold text-gray-700">
                            {{ $isEdit ? '✏️ Edit User' : '➕ Tambah User' }}
                        </h3>

                        <div class="w-6"></div> {{-- spacer supaya judul center --}}
                    </div>

                    <!-- Body -->
                    <div class="p-4 sm:p-6 overflow-auto h-full">
                            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-600">Nama</label>
                                <input type="text" wire:model="name"
                                    class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-600">Email</label>
                                <input type="email" wire:model="email"
                                    class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-600">Password</label>
                                <input type="password" wire:model="password"
                                    class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                                    placeholder="{{ $isEdit ? 'Kosongkan jika tidak diubah' : '' }}">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block mb-1 text-sm font-medium text-gray-600">Role</label>
                                <select wire:model="role"
                                        class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                    <option value="">-- Pilih Role --</option>
                                    @foreach ($roles as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex justify-end gap-3 pt-3">
                                <button type="button" wire:click="closeModal"
                                    class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm shadow-sm transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-blue-400 to-blue-500 text-white text-sm shadow hover:from-blue-500 hover:to-blue-600 transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    @endif


</div>
