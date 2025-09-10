<x-layouts.app>
<div class="p-4 sm:p-6 font-sans bg-gray-50 text-gray-800 min-h-screen">
    <h2 class="text-2xl font-semibold mb-6">👥 Manajemen User</h2>

    <!-- Alert Success -->
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tambah User Button -->
    <button wire:click="openModal(false)"
        class="bg-blue-500 hover:bg-blue-400 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition duration-200 mb-4">
        Tambah User
    </button>

    <!-- Tabel User -->
    <div class="overflow-x-auto rounded-lg shadow-sm">
        <table class="min-w-full border-collapse bg-white">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-4 py-2 rounded-tl-lg">#</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2 rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->role->name ?? '-' }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <button wire:click="openModal(true, {{ $user->id }})"
                                class="text-blue-500 hover:underline">Edit</button>
                            <button wire:click="delete({{ $user->id }})"
                                class="text-red-500 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-20 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300 px-4">
        <div class="bg-white rounded-xl p-6 w-full max-w-md sm:max-w-lg md:max-w-xl shadow-xl transform transition-all duration-300">
            <h3 class="text-xl font-semibold mb-4">{{ $isEdit ? 'Edit User' : 'Tambah User' }}</h3>

            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-3">
                <input type="text" wire:model="name" placeholder="Nama"
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                <input type="email" wire:model="email" placeholder="Email"
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                <input type="password" wire:model="password" placeholder="Password"
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">

                <select wire:model="role" class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                    <option value="">-- Pilih Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-4">
                    <button type="button" wire:click="closeModal"
                        class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg transition w-full sm:w-auto">Batal</button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-lg transition w-full sm:w-auto">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
</x-layouts.app>