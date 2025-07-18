<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $doctor_id ? 'Edit Data Dokter' : 'Tambah Dokter Baru' }}</h3>

                        @if (session()->has('message'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('message') }}</span>
                            </div>
                        @endif

                        <form wire:submit.prevent="save">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Dokter</label>
                                    <input type="text" wire:model.defer="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="specialty" class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                                    <input type="text" wire:model.defer="specialty" id="specialty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('specialty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                    <input type="text" wire:model.defer="phone_number" id="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="mt-4 flex items-center">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    {{ $doctor_id ? 'Update Data' : 'Simpan Dokter' }}
                                </button>
                                @if ($doctor_id)
                                    <button type="button" wire:click="resetForm" class="ml-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                                        Batal
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>

                    <hr class="my-6">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesialisasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($doctors as $doctor)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $doctor->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $doctor->specialty }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $doctor->phone_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button wire:click="edit({{ $doctor->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <button wire:click="delete({{ $doctor->id }})" wire:confirm="Anda yakin ingin menghapus data dokter ini?" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data dokter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
