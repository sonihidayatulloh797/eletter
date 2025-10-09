<div class="flex items-center justify-center min-h-screen bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-xl font-bold text-center mb-6">Lupa Password</h2>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-600 text-sm rounded-lg p-3 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="sendResetLink" class="space-y-5">
            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Email</label>
                <input type="email" wire:model="email" placeholder="Masukkan email Anda"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 outline-none" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Kirim Permintaan Reset
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-blue-500 text-sm">Kembali ke login</a>
        </div>
    </div>
</div>
