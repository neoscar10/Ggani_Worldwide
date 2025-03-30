<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

#[Title('Booking-Appointment')]
class Booking extends Component
{
    public $first_name, $last_name, $phone, $email;
    public $selected_slot;
    public $payment_method;
    public $available_slots = [];

    public function mount()
    {
        $this->available_slots = TimeSlot::where('status', 'available')->get();
    }

    public function placeBooking()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'selected_slot' => 'required',
            'payment_method' => 'required',
            'email' => 'required|email'
        ]);

        $booking = \App\Models\Booking::create([
            'user_id' => Auth::id(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'slot_id' => $this->selected_slot,
            'payment_method' => $this->payment_method,
            'status' => 'pending',
            'pa'
        ]);

        // Mark slot as booked
        TimeSlot::where('id', $this->selected_slot)->update(['status' => 'booked']);

        if ($this->payment_method === 'stripe') {
            return $this->processStripePayment($booking);
        }

        if ($this->payment_method === 'paypal') {
            return $this->processPayPalPayment($booking);
        }
        // SSend booking confirmation mail if pay at appointment is selected, 
        if($this->payment_method === 'cash'){
            Mail::to($booking->email)->send(new BookingConfirmationMail($booking));
            return redirect('/')->with('success', 'Reservation successfull');
        }

        session()->flash('success', 'Booking placed successfully!');
    }

    public function processStripePayment($booking)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => ['name' => 'Tennis Consultation'],
                    'unit_amount' => 5000, // $50.00 .......THIS CAN BE ALTERED DEPENDING ON PRICING LATE
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('booking.success', ['booking' => $booking->id]),
            'cancel_url' => route('booking.cancel'),
        ]);

        return redirect()->away($checkoutSession->url);
    }
    public function processPayPalPayment($booking)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => env('PAYPAL_CURRENCY', 'USD'),
                        "value" => "50.00" // Adjust price as needed
                    ],
                ]
            ],
            "application_context" => [
                "return_url" => route('booking.success', ['booking' => $booking->id]),
                "cancel_url" => route('booking.cancel'),
            ]
        ]);

        if (isset($response['id']) && $response['status'] == 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            session()->flash('error', 'Something went wrong with PayPal.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.booking');
    }
}

