<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\Booking;
use App\Mail\AppointmentReminderMail;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $bookings = Booking::where('status', 'pending')
            ->whereHas('slot', function ($query) {
                $query->whereDate('slot_datetime', now()->addDay()); // Check the slot date
            })
            ->get();

        foreach ($bookings as $booking) {
            Mail::to($booking->email)->send(new AppointmentReminderMail($booking));
        }
    })->dailyAt('01:53'); // Runs every day at 8 AM
}


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
