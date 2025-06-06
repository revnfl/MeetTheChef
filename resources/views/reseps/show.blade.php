<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $resep->masakan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <div>
                        <h3 class="font-bold">Bahan:</h3>
                        <p>{!! nl2br(e($resep->bahan)) !!}</p>
                    </div>
                    <div>
                        <h3 class="font-bold">Langkah:</h3>
                        <p>{!! nl2br(e($resep->langkah)) !!}</p>
                    </div>
                    <a href="{{ route('reseps.index') }}" class="text-blue-500 underline"><br>⬅ Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
