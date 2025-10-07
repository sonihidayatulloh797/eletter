<div class="p-4">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Disposisi Surat Masuk: {{ $surat->no_surat ?? '-' }}</h1>
        <button wire:click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Tambah Disposisi
        </button>
    </div>

    {{-- Search --}}
    <div class="mb-4">
        <input 
            type="text" 
            wire:model.live="search" 
            class="border rounded px-3 py-2 w-full"
            placeholder="🔍 Cari disposisi..."
        >
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 cursor-pointer" wire:click="sortBy('user_id')">User</th>
                    <th class="px-4 py-2">Catatan</th>
                    <th class="px-4 py-2 cursor-pointer" wire:click="sortBy('status')">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($disposisis as $d)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $d->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $d->catatan }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded-lg
                                @if($d->status === 'belum_dibaca') bg-gray-200 text-gray-700
                                @elseif($d->status === 'dibaca') bg-blue-200 text-blue-700
                                @else bg-green-200 text-green-700 @endif">
                                {{ ucfirst(str_replace('_',' ',$d->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <button wire:click="openModal({{ $d->id }})" 
                                class="px-3 py-1 rounded-xl text-xs bg-yellow-400 text-white shadow hover:bg-yellow-500">
                                ✏️ Edit
                            </button>
                            <button wire:click="delete({{ $d->id }})" 
                                class="px-3 py-1 rounded-xl text-xs bg-red-500 text-white shadow hover:bg-red-600"
                                onclick="return confirm('Yakin hapus disposisi ini?')">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada disposisi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $disposisis->links() }}
    </div>

    {{-- Modal --}}
    @if($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40 backdrop-blur-sm z-50">
            <div class="bg-white rounded-xl shadow-lg w-full max-w-lg overflow-hidden
                @if($isFullscreen) w-full h-full max-w-none m-4 @endif
                @if($isMinimized) hidden @endif">
                
                {{-- Modal Header with macOS buttons --}}
                <div class="flex items-center justify-between bg-gray-50 px-4 py-2 border-b">
                    <div class="flex items-center gap-2">
                        <button wire:click="closeModal" class="w-3 h-3 rounded-full bg-red-500 hover:bg-red-600"></button>
                        <button wire:click="restore" class="w-3 h-3 rounded-full bg-yellow-400 hover:bg-yellow-500"></button>
                        <button wire:click="toggleFullscreen" class="w-3 h-3 rounded-full bg-green-500 hover:bg-green-600"></button>
                    </div>
                    <h2 class="font-semibold">{{ $disposisiId ? 'Edit Disposisi' : 'Tambah Disposisi' }}</h2>
                    <span></span>
                </div>

                {{-- Modal Body --}}
                <div class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium">User</label>
                        <select wire:model="user_id" class="w-full border rounded-lg px-3 py-2">
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Catatan</label>
                        <textarea wire:model="catatan" class="w-full border rounded-lg px-3 py-2"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Status</label>
                        <select wire:model="status" class="w-full border rounded-lg px-3 py-2">
                            <option value="belum_dibaca">Belum Dibaca</option>
                            <option value="dibaca">Dibaca</option>
                            <option value="ditindaklanjuti">Ditindaklanjuti</option>
                        </select>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex justify-end gap-2 bg-gray-50 px-4 py-2 border-t">
                    <button wire:click="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                    <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
                </div>
            </div>
        </div>
    @endif
</div>
