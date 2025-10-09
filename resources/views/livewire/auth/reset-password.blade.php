<div class="flex items-center justify-center min-h-screen bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-xl font-bold text-center mb-6">Reset Password</h2>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-600 text-sm rounded-lg p-3 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="resetPassword" class="space-y-5">
            <input type="hidden" wire:model="email">

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Password Baru</label>
                <input type="password" wire:model="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 outline-none" required>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                <input type="password" wire:model="confirm_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 outline-none" required>
                @error('confirm_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Simpan Password Baru
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-blue-500 text-sm">Kembali ke login</a>
        </div>
    </div>
</div>
