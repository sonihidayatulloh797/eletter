<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 px-4">
    <div class="bg-white/90 backdrop-blur-md p-8 rounded-3xl shadow-2xl w-full max-w-lg border border-blue-100 transform -translate-y-20">
        <div class="flex items-center justify-center mb-6">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=3b82f6&color=fff"
                     alt="Avatar"
                     class="w-24 h-24 rounded-full shadow-lg border-4 border-blue-500/20">
                <div class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 cursor-pointer hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Profil Saya</h2>
        <p class="text-center text-gray-500 text-sm mb-6">Kelola data akun kamu dengan mudah ✨</p>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded-xl mb-4 text-sm text-center">
                ✅ {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="updateProfile" class="space-y-5">
            <div>
                <label class="text-sm font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text"
                       wire:model="name"
                       class="w-full border border-gray-200 rounded-xl p-2.5 mt-1 focus:ring-2 focus:ring-blue-400 focus:outline-none transition duration-150 ease-in-out"
                       placeholder="Masukkan nama kamu...">
            </div>

            <div>
                <label class="text-sm font-semibold text-gray-700">Alamat Email</label>
                <input type="email"
                       wire:model="email"
                       class="w-full border border-gray-200 rounded-xl p-2.5 mt-1 focus:ring-2 focus:ring-blue-400 focus:outline-none transition duration-150 ease-in-out"
                       placeholder="Masukkan email kamu...">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold tracking-wide shadow-md transition duration-150 ease-in-out">
                💾 Simpan Perubahan
            </button>
        </form>
    </div>
</div>
