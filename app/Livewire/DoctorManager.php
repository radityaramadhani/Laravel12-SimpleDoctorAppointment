<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;

class DoctorManager extends Component
{
    public $doctors;
    public $name;
    public $specialty;
    public $phone_number;
    public $doctor_id;

    protected $rules = [
        'name' => 'required|string|min:3',
        'specialty' => 'required|string',
        'phone_number' => 'required|string|max:15'
    ];

    public function mount()
    {
        $this->loadDoctors();
    }

    public function loadDoctors()
    {
        $this->doctors = Doctor::orderBy('name')->get();
    }

    public function save()
    {
        $this->validate();

        if ($this->doctor_id) {
            $doctor = Doctor::findOrFail($this->doctor_id);
            $doctor->update([
                'name' => $this->name,
                'specialty' => $this->specialty,
                'phone_number' => $this->phone_number,
            ]);
            session()->flash('message', 'Data dokter berhasil diubah.');
        } else {
            Doctor::create([
                'name' => $this->name,
                'specialty' => $this->specialty,
                'phone_number' => $this->phone_number,
            ]);
            session()->flash('message', 'Data dokter berhasil disimpan.');
        }

        $this->resetForm();
        $this->loadDoctors();
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $this->doctor_id = $id;
        $this->name = $doctor->name;
        $this->specialty = $doctor->specialty;
        $this->phone_number = $doctor->phone_number;
    }

    public function delete($id)
    {
        Doctor::findOrFail($id)->delete();
        session()->flash('message', 'Data dokter berhasil dihapus.');
        $this->loadDoctors();
    }

    public function resetForm()
    {
        $this->reset(['name', 'specialty', 'phone_number', 'doctor_id']);
    }

    public function render()
    {
        return view('livewire.doctor-manager')
            ->layout('layouts.app');
    }
}
