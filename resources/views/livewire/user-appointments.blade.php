<div class="container mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">My Appointments</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($appointments->isEmpty())
        <div class="text-center py-10">
            <p class="text-gray-500 text-lg">You have no upcoming appointments.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($appointments as $appointment)
                <div class="bg-white shadow-lg rounded-xl p-6 border">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Appointment Date: 
                        <span class="text-blue-600">
                            {{ \Carbon\Carbon::parse($appointment->slot->slot_datetime)->format('F j, Y g:i A') }}
                        </span>
                    </h3>

                    <p class="mt-2 text-gray-600">
                        <strong>Status: </strong>
                        <span class="px-3 py-1 rounded-lg text-white text-sm
                            {{ $appointment->appointment_status === 'pending' ? 'bg-yellow-500' : '' }}
                            {{ $appointment->appointment_status === 'completed' ? 'bg-green-500' : '' }}
                            {{ $appointment->appointment_status === 'cancelled' ? 'bg-red-500' : '' }}">
                            {{ ucfirst($appointment->appointment_status) }}
                        </span>
                    </p>

                    <p class="mt-2 text-gray-600">
                        <strong>Payment Method:</strong> {{ ucfirst($appointment->payment_method) }}
                    </p>

                    <div class="mt-4">
                        @if ($appointment->appointment_status === 'pending')
                            <button wire:click="confirmCancel({{ $appointment->id }})"
                                class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
                                Cancel Appointment
                            </button>
                        @else
                            <p class="text-gray-400 text-sm italic">Cancellation not allowed</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Cancel Confirmation Modal -->
    <div x-data="{ open: @entangle('showCancelModal') }">
        <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Cancel Appointment</h3>
                <p class="text-gray-600 mb-4">Are you sure you want to cancel this appointment?</p>

                <div class="flex justify-end gap-4">
                    <button type="button" x-on:click="open = false"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        No
                    </button>
                    <button type="button" wire:click="cancelAppointment"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        Yes, Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
