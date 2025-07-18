<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        {{-- Judul dinamis --}}
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            {{ $patient_id ? 'Edit Data Pasien' : 'Tambah Pasien Baru' }}
                        </h3>

                        {{-- ... bagian notifikasi session ... --}}
                        @if (session()->has('message'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('message') }}</span>
                            </div>
                        @endif

                        <form wire:submit.prevent="savePatient">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                    <select wire:model="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input type="date" wire:model="date_of_birth" id="date_of_birth" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <textarea wire:model="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                    <input type="text" wire:model="phone_number" id="phone_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="NIK" class="block text-sm font-medium text-gray-700">NIK KTP</label>
                                    <input type="text" wire:model="NIK" id="NIK" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('NIK') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="mt-4">
                                    <label for="photo" class="block text-sm font-medium text-gray-700">Foto Pasien</label>
                                    <input type="file" wire:model="photo" id="photo" class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('photo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                                    @if ($photo)
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-600">Preview:</p>
                                            @if (is_object($photo))
                                                {{-- Saat user baru memilih file --}}
                                                <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="h-32 rounded-md shadow border border-gray-200 mt-1">
                                            @else
                                                {{-- Saat data berasal dari database --}}
                                                <img src="{{ asset('storage/photos/' . $photo) }}" alt="Preview" class="h-32 rounded-md shadow border border-gray-200 mt-1">
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 flex items-center">
                                {{-- Tombol simpan/update dinamis --}}
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ $patient_id ? 'Update Data' : 'Simpan Pasien' }}
                                </button>

                                {{-- Tombol batal, hanya muncul saat mode edit --}}
                                @if ($patient_id)
                                    <button type="button" wire:click="resetForm" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Batal
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>

                    <hr class="my-6">

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Pasien</h3>
                        {{-- Searchbar --}}
                        <div class="mb-4">
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Cari berdasarkan nama atau nomor telepon..."
                                class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                {{-- Ganti bagian thead Anda menjadi seperti ini --}}
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl. Daftar</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th> {{-- <-- KOLOM BARU --}}
                                    </tr>
                                </thead>
                                </thead>
                                {{-- Ganti bagian perulangan @forelse di tbody Anda --}}
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($patients as $patient)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $patient->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d F Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->phone_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $patient->created_at->format('d/m/Y H:i') }}</td>
                                            {{-- KOLOM AKSI BARU --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button wire:click="editPatient({{ $patient->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                <button wire:click="deletePatient({{ $patient->id }})" wire:confirm="Anda yakin ingin menghapus data pasien ini?" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            {{-- Tambahkan colspan="5" karena kolom kita sekarang ada 5 --}}
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada data pasien.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $patients->links() }}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
