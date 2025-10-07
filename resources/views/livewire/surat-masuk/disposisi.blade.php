<x-layout>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">
            📑 Disposisi Surat Masuk #{{ $surat->id }}
        </h2>

        <livewire:disposisi.disposisi-management :suratMasukId="$surat->id" />

        <div class="mt-6">
            <a href="{{ route('surat-masuk.index') }}"
               class="px-4 py-2 rounded-xl bg-gray-500 text-white hover:bg-gray-600">
                ⬅️ Kembali
            </a>
        </div>
    </div>
</x-layout>
