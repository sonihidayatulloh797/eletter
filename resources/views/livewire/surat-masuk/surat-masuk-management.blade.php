<div class="p-4 sm:p-6 bg-gray-100 min-h-screen font-sans">

    <h2 class="text-lg sm:text-xl font-bold mb-6 text-gray-800">📩 Manajemen Surat Masuk</h2>

    @if (session()->has('message'))
        <div class="bg-green-50 text-green-700 px-4 py-2 rounded-2xl mb-4 shadow-sm border border-green-200 text-sm sm:text-base">
            ✅ {{ session('message') }}
        </div>
    @endif

    <!-- Tombol Tambah -->
    <button wire:click="openModal(false)"
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
        <table class="min-w-[1000px] text-xs sm:text-sm border-collapse">
            <thead class="text-gray-600 border-b bg-gray-50/70">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left cursor-pointer" wire:click="sortBy('no_surat')">
                        No Surat {!! $sortField === 'no_surat' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left cursor-pointer" wire:click="sortBy('unit_pengirim')">
                        Unit Pengirim {!! $sortField === 'unit_pengirim' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left cursor-pointer" wire:click="sortBy('unit_penerima')">
                        Unit Penerima {!! $sortField === 'unit_penerima' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
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
                        <td class="p-3">{{ $surat->unit_pengirim }}</td>
                        <td class="p-3">{{ $surat->unit_penerima }}</td>
                        <td class="p-3">{{ $surat->perihal }}</td>
                        <td class="p-3">{{ $surat->tanggal }}</td>
                        <td class="p-3 flex gap-2 flex-wrap">
                            <button wire:click="openModal(true, {{ $surat->id }})"
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
                        <td colspan="7" class="text-center p-4 text-gray-500">
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
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50 px-4">
            @if($isMinimized)
                <div class="fixed bottom-6 left-6 z-50">
                    <div class="flex items-center gap-3 bg-white/90 backdrop-blur-md rounded-full px-3 py-2 shadow-lg border border-gray-200 cursor-pointer"
                         wire:click="restore">
                        <div class="flex items-center gap-2">
                            <button wire:click.stop="closeModal" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600"></button>
                            <button wire:click.stop="restore" class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500"></button>
                            <button wire:click.stop="toggleFullscreen" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600"></button>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-800">
                            {{ $isEdit ? '✏️ Edit Surat' : '➕ Tambah Surat' }}
                        </span>
                    </div>
                </div>
            @else
                <div class="@if($isFullscreen) w-full max-w-none h-[90vh] max-h-[90vh] rounded-xl @else w-full max-w-lg rounded-3xl @endif
                            bg-white/95 backdrop-blur-xl shadow-2xl border border-gray-200 overflow-hidden transition-all duration-200">
                    <div class="flex items-center justify-between px-3 py-2 bg-gray-50 border-b">
                        <div class="flex items-center space-x-2">
                            <button wire:click="closeModal" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600"></button>
                            <button wire:click="minimize" class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500"></button>
                            <button wire:click="toggleFullscreen" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600"></button>
                        </div>
                        <h3 class="text-sm sm:text-base font-semibold text-gray-700">
                            {{ $isEdit ? '✏️ Edit Surat' : '➕ Tambah Surat' }}
                        </h3>
                        <div class="w-6"></div>
                    </div>

                    <div class="p-4 sm:p-6 overflow-auto h-full space-y-4">
                        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
                            <input type="text" wire:model="no_surat" placeholder="No Surat"
                                   class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            <input type="text" wire:model="unit_pengirim" placeholder="Unit Pengirim"
                                   class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            <input type="text" wire:model="unit_penerima" placeholder="Unit Penerima"
                                   class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            <input type="text" wire:model="perihal" placeholder="Perihal"
                                   class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            <textarea wire:model="deskripsi" placeholder="Deskripsi"
                                      class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"></textarea>
                            <input type="date" wire:model="tanggal"
                                   class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            <textarea wire:model="tembusan" placeholder="Tembusan"
                                      class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"></textarea>
                            {{-- <input type="file" wire:model="file_surat"
                                   class="w-full border border-gray-300 rounded-xl p-2 text-sm"> --}}

                            <div
                                x-data="{ isDragging: false, fileName: @entangle('file_surat') }"
                                x-on:dragover.prevent="isDragging = true"
                                x-on:dragleave.prevent="isDragging = false"
                                x-on:drop.prevent="isDragging = false"
                                class="w-full">

                                <label
                                    class="flex flex-col items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-dashed rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50"
                                    :class="{'border-blue-500 bg-blue-50': isDragging}">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8m0 0l-4-4m4 4l4-4M12 12V4" />
                                    </svg>

                                    <span class="text-gray-500 text-sm" x-text="fileName ? fileName.name : 'Drag & drop file atau klik untuk pilih file'"></span>

                                    <input type="file" wire:model="file_surat" class="hidden" @change="fileName = $event.target.files[0]">
                                </label>

                                @error('file_surat')
                                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                                @enderror

                                <!-- Optional: preview file PDF/DOC -->
                                <template x-if="fileName">
                                    <div class="mt-2 p-2 text-sm bg-gray-100 rounded-lg text-gray-700">
                                        <strong>File dipilih:</strong> <span x-text="fileName.name"></span>
                                    </div>
                                </template>
                            </div>

                            @if ($existingFile)
                                <p class="mt-2 text-sm text-gray-700">
                                    File lama:
                                    <a href="{{ Storage::url($existingFile) }}" target="_blank" class="text-blue-500 underline">
                                        {{ basename($existingFile) }}
                                    </a>
                                </p>
                            @endif

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
            @endif
        </div>
    @endif

</div>
