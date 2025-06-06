<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Resep Baru
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="py-6 px-4">
                        <form method="POST" action="{{ route('reseps.store') }}">
                            @csrf


                            <div>
                                <label>Masakan:</label><br>
                                <input type="text" name="masakan" value="{{ old('masakan') }}"
                                    class="w-full border rounded px-2 py-1">
                            </div>


                            <div class="mt-4">
                                <label>Bahan:</label><br>
                                <textarea name="bahan" rows="5" class="w-full border rounded px-2 py-1">{{ old('bahan') }}</textarea>
                            </div>

                            <div class="mt-4">
                                <label>Langkah:</label><br>
                                <textarea name="langkah" rows="5" class="w-full border rounded px-2 py-1">{{ old('langkah') }}</textarea>
                            </div>


                            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>