<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function success(Request $request, $booking)
    {
        // Find the booking and update status
        $booking = Booking::findOrFail($booking);
        $booking->status = 'paid';
        $booking->save();

        // Send Mail
        Mail::to($booking->email)->send(new BookingConfirmationMail($booking));

        return redirect()->route('home')->with('success', 'Payment successful! Your booking is confirmed.');
    }

    public function cancel()
    {
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
    }
}