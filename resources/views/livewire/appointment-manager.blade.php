<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Janji Temu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $appointment_id ? 'Edit Janji Temu' : 'Buat Janji Temu Baru' }}</h3>

                        @if (session()->has('message'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                <span class="block sm:inline">{{ session('message') }}</span>
                            </div>
                        @endif

                        <form wire:submit.prevent="save">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Pasien</label>
                                    <select wire:model.defer="patient_id" id="patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">-- Pilih Pasien --</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('patient_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="doctor_id" class="block text-sm font-medium text-gray-700">Dokter</label>
                                    <select wire:model.defer="doctor_id" id="doctor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">-- Pilih Dokter --</option>
                                        @foreach($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialty }})</option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="schedule_time" class="block text-sm font-medium text-gray-700">Jadwal</label>
                                    <input type="datetime-local" wire:model.defer="schedule_time" id="schedule_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('schedule_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model.defer="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="Scheduled">Scheduled</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                    <textarea wire:model.defer="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    {{ $appointment_id ? 'Update Janji Temu' : 'Simpan Janji Temu' }}
                                </button>
                                @if ($appointment_id)
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $appointment->patient->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appointment->doctor->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->schedule_time)->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($appointment->status == 'Scheduled') bg-blue-100 text-blue-800 @endif
                                                @if($appointment->status == 'Completed') bg-green-100 text-green-800 @endif
                                                @if($appointment->status == 'Cancelled') bg-red-100 text-red-800 @endif">
                                                {{ $appointment->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button wire:click="edit({{ $appointment->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <button wire:click="delete({{ $appointment->id }})" wire:confirm="Anda yakin ingin menghapus janji temu ini?" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada data janji temu.</td>
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
