<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentManager extends Component
{
    public $appointments, $patients, $doctors;
    public $patient_id, $doctor_id, $schedule_time, $status, $notes, $appointment_id;

    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
        'doctor_id' => 'required|exists:doctors,id',
        'schedule_time' => 'required|date',
        'status' => 'required|string',
    ];

    public function mount()
    {
        $this->loadInitialData();
    }

    public function loadInitialData()
    {
        $this->appointments = Appointment::with(['patient', 'doctor'])->orderBy('schedule_time', 'desc')->get();
        $this->patients = Patient::orderBy('name')->get();
        $this->doctors = Doctor::orderBy('name')->get();
        $this->status = 'Scheduled'; // Default status
    }

    public function save()
    {
        $this->validate();

        $data = [
            'patient_id' => $this->patient_id,
            'doctor_id' => $this->doctor_id,
            'schedule_time' => $this->schedule_time,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->appointment_id) {
            $appointment = Appointment::findOrFail($this->appointment_id);
            $appointment->update($data);
            session()->flash('message', 'Janji temu berhasil diubah.');
        } else {
            Appointment::create($data);
            session()->flash('message', 'Janji temu berhasil dibuat.');
        }

        $this->resetForm();
        $this->loadInitialData();
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $this->appointment_id = $id;
        $this->patient_id = $appointment->patient_id;
        $this->doctor_id = $appointment->doctor_id;
        $this->schedule_time = \Carbon\Carbon::parse($appointment->schedule_time)->format('Y-m-d\TH:i');
        $this->status = $appointment->status;
        $this->notes = $appointment->notes;
    }

    public function delete($id)
    {
        Appointment::findOrFail($id)->delete();
        session()->flash('message', 'Janji temu berhasil dihapus.');
        $this->loadInitialData();
    }

    public function resetForm()
    {
        $this->reset(['patient_id', 'doctor_id', 'schedule_time', 'status', 'notes', 'appointment_id']);
        $this->status = 'Scheduled'; // Reset ke default
    }

    public function render()
    {
        return view('livewire.appointment-manager')
            ->layout('layouts.app');
    }
}
