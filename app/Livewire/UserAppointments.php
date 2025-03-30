<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class UserAppointments extends Component
{
    public $appointments;
    public $selectedAppointmentId;
    public $showCancelModal = false;

    public function mount()
    {
        $this->appointments = Booking::where('user_id', Auth::id())->latest()->get();
    }

    public function confirmCancel($appointmentId)
    {
        $this->selectedAppointmentId = $appointmentId;
        $this->showCancelModal = true;
    }

    public function cancelAppointment()
    {
        $appointment = Booking::find($this->selectedAppointmentId);

        if (!$appointment || $appointment->appointment_status !== 'pending') {
            session()->flash('error', 'Appointment cannot be cancelled.');
            return;
        }

        $appointment->update(['appointment_status' => 'cancelled']);
        session()->flash('success', 'Appointment cancelled successfully.');

        $this->showCancelModal = false;
        $this->mount(); // Refresh the appointments list
    }

    public function render()
    {
        return view('livewire.user-appointments');
    }
}