<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login E-Letter</h2>

        <form wire:submit.prevent="login">
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" wire:model="email" class="w-full px-3 py-2 border rounded-lg" required>
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" wire:model="password" class="w-full px-3 py-2 border rounded-lg" required>
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">
                Login
            </button>
        </form>
    </div>
</div>
