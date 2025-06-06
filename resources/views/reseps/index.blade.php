<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Resep
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @auth
                        <a href="{{ route('reseps.create') }}" class="text-blue-500 underline">➕ Buat Resep Baru</a>
                    @endauth

                    <ul class="mt-4 space-y-2">
                        @foreach ($reseps as $resep)
                            <li>
                                <a href="{{ route('reseps.show', $resep) }}"
                                    class="text-lg font-medium">{{ $resep->masakan }}</a>
                                @auth
                                    | <a href="{{ route('reseps.edit', $resep) }}" class="text-yellow-600">Edit</a>
                                    <form action="{{ route('reseps.destroy', $resep) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin hapus?')"
                                            class="text-red-600">Hapus</button>
                                    </form>
                                @endauth
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
