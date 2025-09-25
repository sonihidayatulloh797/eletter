<div class="flex items-center justify-center min-h-screen bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        
        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <div class="w-24 h-24 rounded-full overflow-hidden shadow-md border border-gray-200 flex items-center justify-center">
                <img src="{{ asset('assets/img/logo-unla2.png') }}" alt="Logo UNLA" class="object-contain w-full h-full">
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Login E-Letter UNLA</h1>
            <p class="text-gray-500 text-sm mt-1">Silakan masuk menggunakan akun Anda</p>
        </div>

        <!-- Alert -->
        @if (session()->has('error'))
            <div class="bg-red-50 text-red-600 px-4 py-2 rounded-lg mb-5 border border-red-200 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Form -->
        <form wire:submit.prevent="login" class="space-y-5">
            <!-- Email -->
            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Email</label>
                <input type="email" wire:model="email"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition"
                       placeholder="contoh@unla.ac.id" required>
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Password</label>
                <input type="password" wire:model="password"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none transition"
                       placeholder="Masukkan password" required>
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-400 to-blue-500 text-white py-2.5 rounded-lg font-semibold text-sm hover:from-blue-500 hover:to-blue-600 transition-all duration-200">
                Login
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-gray-400 text-xs mt-8">
            © {{ date('Y') }} Universitas Langlangbuana. All rights reserved.
        </p>
    </div>
</div>
