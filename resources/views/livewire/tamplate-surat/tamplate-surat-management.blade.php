<div class="p-4 sm:p-6 bg-gray-100 min-h-screen">

    <h2 class="text-lg sm:text-xl font-bold mb-6 text-gray-800">📑 Manajemen Template Surat</h2>

    @if (session()->has('message'))
        <div class="bg-green-50 text-green-700 px-4 py-2 rounded-2xl mb-4 shadow-sm border border-green-200 text-sm sm:text-base">
            ✅ {{ session('message') }}
        </div>
    @endif

    <!-- Tombol Tambah -->
    <button wire:click="openModal"
        class="bg-gradient-to-r from-blue-400 to-blue-500 text-white px-4 py-2 rounded-xl mb-5 text-sm sm:text-base shadow hover:from-blue-500 hover:to-blue-600 transition-all duration-200">
        + Tambah Template
    </button>

    <!-- Filter & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
        <input type="text" wire:model.live="search"
               placeholder="🔍 Cari template..."
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
        <table class="w-full text-xs sm:text-sm border-collapse table-auto">
            <thead class="text-gray-600 border-b bg-gray-50/70">
                <tr>
                    <th class="p-3 text-left w-12">No</th>
                    <th class="p-3 text-left">Nama Template</th>
                    <th class="p-3 text-left">Kategori</th>
                    <th class="p-3 text-left">File</th>
                    <th class="p-3 text-left w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($templates as $index => $tpl)
                    <tr class="border-b hover:bg-gray-50/70 transition">
                        <td class="p-3 text-center">
                            {{ $templates->firstItem() + $index }}
                        </td>
                        <td class="p-3 font-medium">{{ $tpl->nama_template }}</td>
                        <td class="p-3 capitalize">{{ $tpl->kategori }}</td>
                        <td class="p-3">
                            @if ($tpl->file_template)
                                <a href="{{ Storage::url($tpl->file_template) }}" target="_blank"
                                    class="text-blue-500 underline hover:text-blue-700">
                                    📄 Lihat
                                </a>
                            @else
                                <span class="text-gray-400">Tidak ada file</span>
                            @endif
                        </td>
                        <td class="p-3 flex gap-2 flex-wrap">
                            <button wire:click="openModal({{ $tpl->id }})"
                                class="px-3 py-1 rounded-xl text-xs bg-yellow-400 text-white shadow hover:bg-yellow-500">
                                ✏️ Edit
                            </button>
                            <button wire:click="delete({{ $tpl->id }})"
                                class="px-3 py-1 rounded-xl text-xs bg-red-500 text-white shadow hover:bg-red-600"
                                onclick="return confirm('Yakin hapus template ini?')">
                                🗑️ Hapus
                            </button>
                            <button wire:click="generate({{ $tpl->id }})"
                                class="px-3 py-1 rounded-xl text-xs bg-green-500 text-white shadow hover:bg-green-600">
                                📝 Buat Surat
                            </button>                            
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-500">
                            🙅 Belum ada data template.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $templates->links() }}
    </div>

    {{-- Modal ala macOS --}}
    @if ($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50 px-4">
            <div
                class="@if($isFullscreen) w-full max-w-none h-[90vh] max-h-[90vh] rounded-xl @else w-full max-w-lg rounded-3xl @endif
                    bg-white/95 backdrop-blur-xl shadow-2xl border border-gray-200 overflow-hidden transition-all duration-200">

                <!-- Header ala macOS -->
                <div class="flex items-center justify-between px-3 py-2 bg-gray-50 border-b">
                    <div class="flex items-center space-x-2">
                        <button wire:click="closeModal" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600"></button>
                        <button wire:click="minimize" class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500"></button>
                        <button wire:click="toggleFullscreen" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600"></button>
                    </div>
                    <h3 class="text-sm sm:text-base font-semibold text-gray-700">
                        {{ $templateId ? '✏️ Edit Template' : '➕ Tambah Template' }}
                    </h3>
                    <div class="w-6"></div>
                </div>

                <!-- Body -->
                <div class="p-4 sm:p-6 overflow-auto h-full">
                    <form wire:submit.prevent="save" class="space-y-4">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-600">Nama Template</label>
                            <input type="text" wire:model="nama_template"
                                class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            @error('nama_template') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-600">Kategori</label>
                            <select wire:model="kategori"
                                class="w-full border border-gray-300 rounded-xl p-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                <option value="undangan">Undangan</option>
                                <option value="peminjaman">Peminjaman</option>
                                <option value="sk">SK</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Upload file ala drag-drop -->
                        <div x-data="{
                            isDropping: false,
                            fileName: null,
                            handleFiles(event) {
                                const file = event.target.files[0];
                                if (!file) return;
                                this.fileName = file.name;
                            },
                            dropFile(event) {
                                const file = event.dataTransfer.files[0];
                                if (!file) return;
                                this.$refs.fileInput.files = event.dataTransfer.files;
                                this.$refs.fileInput.dispatchEvent(new Event('change'));
                            }
                        }" class="w-full">
                            <label class="block mb-1 text-sm font-medium text-gray-600">File Template</label>
                            <div
                                class="relative flex flex-col items-center justify-center w-full border-2 border-dashed rounded-xl cursor-pointer transition p-6"
                                :class="isDropping ? 'border-blue-400 bg-blue-50' : 'border-gray-300 hover:border-blue-400 hover:bg-blue-50'"
                                @dragover.prevent="isDropping = true"
                                @dragleave.prevent="isDropping = false"
                                @drop.prevent="isDropping = false; dropFile($event)"
                                @click="$refs.fileInput.click()"
                            >
                                <template x-if="!fileName">
                                    <div class="text-center space-y-2">
                                        <p class="text-sm text-gray-500">Tarik & lepaskan file di sini</p>
                                        <p class="text-xs text-gray-400">atau klik untuk pilih file</p>
                                    </div>
                                </template>
                                <template x-if="fileName">
                                    <p class="text-sm text-gray-700">📄 <span x-text="fileName"></span></p>
                                </template>
                                <input type="file" wire:model="new_file" x-ref="fileInput" class="hidden" @change="handleFiles($event)">
                            </div>
                            @error('new_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            <div wire:loading wire:target="new_file" class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full animate-pulse w-2/3"></div>
                            </div>

                            @if ($file_template)
                                <p class="text-xs mt-2">File lama: <a href="{{ Storage::url($file_template) }}" target="_blank" class="text-blue-500 underline">Lihat</a></p>
                            @endif
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
        </div>
    @endif

</div>
