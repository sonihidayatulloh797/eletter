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
<<<<<<< HEAD
        <table class="min-w-[1000px] text-xs sm:text-sm border-collapse">
=======
        <table class="w-full text-xs sm:text-sm border-collapse table-auto">
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
            <thead class="text-gray-600 border-b bg-gray-50/70">
                <tr>
                    <th class="p-3 text-left w-10">No</th>
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
                    <th class="p-3 text-left cursor-pointer w-32" wire:click="sortBy('tanggal')">
                        Tanggal {!! $sortField === 'tanggal' ? ($sortDirection === 'asc' ? '⬆️' : '⬇️') : '' !!}
                    </th>
                    <th class="p-3 text-left w-32">File</th>
                    <th class="p-3 text-left w-32">Dibuat Oleh</th>
                    <th class="p-3 text-left w-32">Diedit Oleh</th>
                    <th class="p-3 text-left w-28">Aksi</th>
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
                        <td class="p-3 whitespace-nowrap">{{ $surat->tanggal }}</td>

                        <!-- File link -->
                        <td class="p-3">
                            @if ($surat->file_surat)
                                <a href="{{ Storage::url($surat->file_surat) }}" target="_blank"
                                    class="text-blue-500 underline hover:text-blue-700">
                                    📄 Lihat File
                                </a>
                            @else
                                <span class="text-gray-400">Tidak ada file</span>
                            @endif
                        </td>

                        <!-- Creator -->
                        <td class="p-3">
                            {{ $surat->user->name ?? '-' }}
                        </td>
                        <!-- Updater -->
                        <td class="p-3">
                            {{ $surat->user->role->name ?? '-' }}
                        </td>

                        <!-- Aksi -->
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
                            <!-- Tombol ke Disposisi -->
                            <a href="{{ route('disposisi.index', $surat->id) }}"
                                class="px-3 py-1 rounded-xl text-xs bg-blue-500 text-white shadow hover:bg-blue-600">
                                📌 Disposisi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
<<<<<<< HEAD
                        <td colspan="7" class="text-center p-4 text-gray-500">
=======
                        <td colspan="9" class="text-center p-4 text-gray-500">
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
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

<<<<<<< HEAD
    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50 px-4">
            @if($isMinimized)
                <div class="fixed bottom-6 left-6 z-50">
                    <div class="flex items-center gap-3 bg-white/90 backdrop-blur-md rounded-full px-3 py-2 shadow-lg border border-gray-200 cursor-pointer"
                         wire:click="restore">
=======
    @if ($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50 px-4">
            {{-- MINIMIZED BAR --}}
            @if($isMinimized)
                <div class="fixed bottom-6 left-6 z-50">
                    <div
                        class="flex items-center gap-3 bg-white/90 backdrop-blur-md rounded-full px-3 py-2 shadow-lg border border-gray-200 cursor-pointer"
                        wire:click="restore">
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
                        <div class="flex items-center gap-2">
                            <button wire:click.stop="closeModal" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600"></button>
                            <button wire:click.stop="restore" class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500"></button>
                            <button wire:click.stop="toggleFullscreen" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600"></button>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-800">
<<<<<<< HEAD
                            {{ $isEdit ? '✏️ Edit Surat' : '➕ Tambah Surat' }}
=======
                            {{ $suratId ? '✏️ Edit Surat' : '➕ Tambah Surat' }}
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
                        </span>
                    </div>
                </div>
            @else
<<<<<<< HEAD
                <div class="@if($isFullscreen) w-full max-w-none h-[90vh] max-h-[90vh] rounded-xl @else w-full max-w-lg rounded-3xl @endif
                            bg-white/95 backdrop-blur-xl shadow-2xl border border-gray-200 overflow-hidden transition-all duration-200">
=======
                {{-- NORMAL / FULLSCREEN MODAL --}}
                <div
                    class="@if($isFullscreen) w-full max-w-none h-[90vh] max-h-[90vh] rounded-xl @else w-full max-w-lg rounded-3xl @endif
                        bg-white/95 backdrop-blur-xl shadow-2xl border border-gray-200 overflow-hidden transition-all duration-200">

                    <!-- Header ala macOS -->
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
                    <div class="flex items-center justify-between px-3 py-2 bg-gray-50 border-b">
                        <div class="flex items-center space-x-2">
                            <button wire:click="closeModal" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600"></button>
                            <button wire:click="minimize" class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500"></button>
                            <button wire:click="toggleFullscreen" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600"></button>
                        </div>
                        <h3 class="text-sm sm:text-base font-semibold text-gray-700">
<<<<<<< HEAD
                            {{ $isEdit ? '✏️ Edit Surat' : '➕ Tambah Surat' }}
=======
                            {{ $suratId ? '✏️ Edit Surat' : '➕ Tambah Surat' }}
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
                        </h3>
                        <div class="w-6"></div>
                    </div>

<<<<<<< HEAD
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
=======
                    <!-- Body -->
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

                            <div x-data="{
                                isDropping: false,
                                preview: null,
                                handleFiles(event) {
                                    const file = event.target.files[0];
                                    if (!file) return;
                                    this.preview = URL.createObjectURL(file);
                                },
                                dropFile(event) {
                                    const file = event.dataTransfer.files[0];
                                    if (!file) return;
                                    this.$refs.fileInput.files = event.dataTransfer.files;
                                    this.$refs.fileInput.dispatchEvent(new Event('change'));
                                }
                                }" 
                                class="w-full"
                            >
                            <label class="block mb-1 text-sm font-medium text-gray-600">File Surat</label>
                            <!-- Drop area -->
                            <div
                                class="relative flex flex-col items-center justify-center w-full border-2 border-dashed rounded-xl cursor-pointer
                                       transition p-6"
                                :class="isDropping ? 'border-blue-400 bg-blue-50' : 'border-gray-300 hover:border-blue-400 hover:bg-blue-50'"
                                @dragover.prevent="isDropping = true"
                                @dragleave.prevent="isDropping = false"
                                @drop.prevent="isDropping = false; dropFile($event)"
                                @click="$refs.fileInput.click()"
                            >
                                <!-- Default content -->
                                <template x-if="!preview">
                                    <div class="text-center space-y-2">
                                        <svg class="w-10 h-10 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16V4a2 2 0 012-2h6a2 2 0 012 2v12m-4 4h-4m0 0v-4h4v4z" />
                                        </svg>
                                        <p class="text-sm text-gray-500">Tarik & lepaskan file di sini</p>
                                        <p class="text-xs text-gray-400">atau klik untuk pilih file</p>
                                    </div>
                                </template>
                        
                                <!-- Preview -->
                                <template x-if="preview">
                                    <div class="relative w-full text-center">
                                        <iframe x-bind:src="preview" class="w-full h-40 rounded-lg border"></iframe>
                                        <button type="button" @click="preview = null; $refs.fileInput.value = ''"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow">
                                            ✕
                                        </button>
                                    </div>
                                </template>
                        
                                <!-- Hidden file input -->
                                <input type="file" wire:model="file_surat" x-ref="fileInput" class="hidden"
                                    @change="handleFiles($event)">
                            </div>
                        
                            @error('file_surat')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        
                            <!-- Progress bar Livewire -->
                            <div wire:loading wire:target="file_surat" class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full animate-pulse w-2/3"></div>
                            </div>
                        </div>                                                    

                            <div class="flex justify-end gap-3 pt-3">
>>>>>>> c5d2b1d8a1858a85ec39a456751c74e2facead1d
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
