<div class="p-4 sm:p-6 bg-gray-100 min-h-screen">

    <h2 class="text-lg sm:text-xl font-bold mb-6 text-gray-800">📩 Manajemen Surat Masuk</h2>

    @if (session()->has('message'))
        <div class="bg-green-50 text-green-700 px-4 py-2 rounded-2xl mb-4 shadow-sm border border-green-200 text-sm sm:text-base">
            ✅ {{ session('message') }}
        </div>
    @endif

    <!-- Tombol Tambah -->
    <button wire:click="openModal"
        class="bg-gradient-to-r from-blue-400 to-blue-500 text-white px-4 py-2 rounded-xl mb-5 text-sm sm:text-base shadow hover:from-blue-500 hover:to-blue-600 transition-all duration-200">
        + Tambah Surat
    </button>

    <!-- Filter & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
        <input type="text" wire:model.live="search"
               placeholder="🔍 Cari surat..."
               class="w-full sm:w-64 border rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">

        <select wire:model.live="perPage"
                class="border rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
            <option value="10">10 / halaman</option>
            <option value="25">25 / halaman</option>
            <option value="50">50 / halaman</option>
            <option value="100">100 / halaman</option>
        </select>
    </div>

    <!-- Table -->
    <div class="w-full p-3 overflow-x-auto bg-white rounded-2xl shadow-lg border border-gray-200">
        <table class="min-w-[900px] text-xs sm:text-sm border-collapse">
            <thead class="text-gray-600 border-b bg-gray-50/70">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left cursor-pointer" wire:click="sortBy('no_surat')">
                        No Surat {!! $sortField === 'no_surat' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left cursor-pointer" wire:click="sortBy('pengirim')">
                        Pengirim {!! $sortField === 'pengirim' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left cursor-pointer" wire:click="sortBy('perihal')">
                        Perihal {!! $sortField === 'perihal' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left cursor-pointer" wire:click="sortBy('tanggal')">
                        Tanggal {!! $sortField === 'tanggal' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($surats as $index => $surat)
                    <tr class="border-b hover:bg-gray-50/70 transition">
                        <td class="p-3">{{ $surats->firstItem() + $index }}</td>
                        <td class="p-3 font-medium">{{ $surat->no_surat }}</td>
                        <td class="p-3">{{ $surat->pengirim }}</td>
                        <td class="p-3">{{ $surat->perihal }}</td>
                        <td class="p-3">{{ $surat->tanggal }}</td>
                        <td class="p-3 flex gap-2 flex-wrap">
                            <button wire:click="openModal({{ $surat->id }})"
                                class="px-3 py-1 rounded-xl text-xs bg-yellow-400 text-white shadow hover:bg-yellow-500">
                                ✏️ Edit
                            </button>
                            <button wire:click="delete({{ $surat->id }})"
                                class="px-3 py-1 rounded-xl text-xs bg-red-500 text-white shadow hover:bg-red-600"
                                onclick="return confirm('Yakin hapus surat ini?')">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500">
                            🙅 Belum ada data surat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $surats->links() }}
    </div>

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50 px-4">
            <div class="w-full max-w-lg rounded-3xl bg-white/95 backdrop-blur-xl shadow-2xl border border-gray-200 overflow-hidden transition-all duration-200">
                <div class="flex items-center justify-between px-3 py-2 bg-gray-50 border-b">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-700">
                        {{ $suratId ? '✏️ Edit Surat' : '➕ Tambah Surat' }}
                    </h3>
                    <button wire:click="closeModal" class="px-2 py-1 text-gray-500 hover:text-gray-700">&times;</button>
                </div>

                <div class="p-4 sm:p-6 overflow-auto h-full">
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-600">No Surat</label>
                            <input type="text" wire:model="no_surat"
                                class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            @error('no_surat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-600">Pengirim</label>
                            <input type="text" wire:model="pengirim"
                                class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            @error('pengirim') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-600">Perihal</label>
                            <textarea wire:model="perihal"
                                class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"></textarea>
                            @error('perihal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-600">Tanggal</label>
                            <input type="date" wire:model="tanggal"
                                class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-600">File Surat</label>
                            <input type="file" wire:model="file_surat"
                                class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            @error('file_surat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-wrap justify-end gap-3 pt-3">
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
        </div>
    @endif

</div>
