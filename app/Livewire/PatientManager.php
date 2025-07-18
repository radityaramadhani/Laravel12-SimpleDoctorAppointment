<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Patient; // Import model patient

class PatientManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    // Properti untuk menampung semua data pasien dari database
    // public $patients;

    // Properti yang terhubung ke form input (wire:model)
    public $name;
    public $gender;
    public $date_of_birth;
    public $address;
    public $phone_number;
    public $NIK; // Nomor Induk Keluarga
    public $photo; // Foto pasien
    public $patient_id;
    public $search = ''; // Properti untuk pencarian
    public $sortBy = 'created_at'; // Kolom default untuk sorting
    public $sortDirection = 'desc'; // Arah default

    protected $queryString = ['search'];

    // Aturan validasi
    protected $rules = [
        'name' => 'required|string|min:3',
        'gender' => 'required|string',
        'date_of_birth' => 'required|date',
        'address' => 'required|string',
        'phone_number' => 'required|string|max:15',
        'NIK' => 'nullable|string|max:16', // Validasi NIK
        'photo' => 'nullable|image|max:2048', // Validasi foto
    ];

    // Method untuk mengambil data pasien dari database
    // public function mount()
    // {
    //     // $this->patients = Patient::all(); // Ambil semua data pasien
    //     $this->loadPatients();
    // }

    // Method untuk memuat data pasien dari database
    // public function loadPatients()
    // {
    //     $this->patients = Patient::orderBy('created_at', 'desc')->get();
    // }


    // Ganti nama method dari savePatient menjadi save agar lebih umum
    public function savePatient()
    {
        // Jalankan validasi
        $this->validate();

        // Cek apakah kita sedang dalam mode edit atau tidak
        if ($this->patient_id) {
            // Jika ada patient_id, berarti kita UPDATE data yang ada
            $patient = Patient::findOrFail($this->patient_id);

            // Simpan file gambar baru jika ada
            if ($this->photo) {
                $filename = 'patient-' . $patient->id . '.png';
                $this->photo->storeAs('photos', $filename, 'public');
                $photoPath = $filename;
            } else {
                $photoPath = $patient->photo; // Pertahankan foto lama jika tidak upload baru
            }

            $patient->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth, // atau gunakan Carbon jika kamu ubah format
                'address' => $this->address,
                'phone_number' => $this->phone_number,
                'NIK' => $this->NIK,
                'photo' => $photoPath, // Simpan path foto baru
            ]);

            session()->flash('message', 'Data pasien berhasil diubah.');
        } else {
            // Jika tidak ada, berarti kita CREATE data baru
            $patient = Patient::create([
                'name' => $this->name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth, // atau gunakan Carbon jika kamu ubah format
                'address' => $this->address,
                'phone_number' => $this->phone_number,
                'NIK' => $this->NIK,
                'photo' => null, // Inisialisasi foto sebagai null
            ]);

            // Lalu simpan foto jika diupload
            if ($this->photo) {
                $filename = 'patient-' . $patient->id . '.png';
                $this->photo->storeAs('photos', $filename, 'public');

                // update kolom `photo` dengan nama file yang baru
                $patient->update(['photo' => $filename]);
            }

            session()->flash('message', 'Data pasien berhasil disimpan.');
        }

        // Reset form dan muat ulang data
        $this->resetForm();
        $this->loadPatients();
    }

    public function resetForm()
    {
        $this->reset(['name', 'gender', 'date_of_birth', 'address', 'phone_number' , 'NIK' , 'photo', 'patient_id']);
    }

    public function editPatient($id)
    {
        // Cari pasien berdasarkan ID
        $patient = Patient::findOrFail($id);

        // Set properti dengan data pasien
        $this->patient_id = $id;
        $this->name = $patient->name;
        $this->gender = $patient->gender;
        $this->date_of_birth = $patient->date_of_birth;
        $this->address = $patient->address;
        $this->phone_number = $patient->phone_number;
        $this->NIK = $patient->NIK;
        $this->photo = $patient->photo;
    }

    public function deletePatient($id)
    {
        Patient::findOrFail($id)->delete();
        session()->flash('message', 'Data pasien berhasil dihapus.');
        $this->loadPatients(); // Muat ulang daftar pasien
    }

    public function render()
    {

        $patients = Patient::query()
            ->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('phone_number', 'like', '%'.$this->search.'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.patient-manager', [
            'patients' => $patients,
        ])->layout('layouts.app');
    }
}
