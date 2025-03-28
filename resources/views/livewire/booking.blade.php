<div class="w-full min-h-screen flex justify-center items-center px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-3xl py-10 px-4 sm:px-6 lg:px-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
            Book a Tennis Consultation
        </h1>

        <form wire:submit.prevent="placeBooking">
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7">
                    <h2 class="text-xl font-bold underline text-gray-700 mb-2">
                        Personal Details
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 mb-1" for="first_name">First Name</label>
                            <input wire:model="first_name" class="w-full rounded-lg border py-2 px-3" id="first_name" type="text">
                            @error('first_name') <div class="text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-1" for="last_name">Last Name</label>
                            <input wire:model="last_name" class="w-full rounded-lg border py-2 px-3" id="last_name" type="text">
                            @error('last_name') <div class="text-sm text-red-500">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-700 mb-1" for="phone">Phone</label>
                        <input wire:model="phone" class="w-full rounded-lg border py-2 px-3" id="phone" type="text">
                        @error('phone') <div class="text-sm text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-4">
                        <label class="block text-gray-700 mb-1" for="email">Email</label>
                        <input wire:model="email" class="w-full rounded-lg border py-2 px-3" id="email" type="text">
                        @error('email') <div class="text-sm text-red-500">{{ $message }}</div> @enderror
                    </div>

                    <h2 class="text-xl font-bold underline text-gray-700 mt-6 mb-2">
                        Select a Time Slot
                    </h2>
                    <select wire:model="selected_slot" class="w-full rounded-lg border py-2 px-3">
                        <option value="">Select a Slot</option>
                        @foreach($available_slots as $slot)
                            <option value="{{ $slot->id }}">
                                {{ \Carbon\Carbon::parse($slot->slot_datetime)->format('l, F j, Y g:i A') }}
                            </option>
                        @endforeach

                    </select>
                    @error('selected_slot') <div class="text-sm text-red-500">{{ $message }}</div> @enderror

                    <h2 class="text-lg font-semibold mt-6 mb-4">Select Payment Method</h2>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input wire:model="payment_method" class="hidden peer" id="paypal" type="radio" value="paypal">
                            <label class="inline-flex items-center justify-between w-full p-5 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-100" for="paypal">
                                <div>PayPal</div>
                            </label>
                        </li>
                        <li>
                            <input wire:model="payment_method" class="hidden peer" id="stripe" type="radio" value="stripe">
                            <label class="inline-flex items-center justify-between w-full p-5 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-100" for="stripe">
                                <div>Credit Card (Stripe)</div>
                            </label>
                        </li>
                        <li>
                            <input wire:model="payment_method" class="hidden peer" id="cash" type="radio" value="cash">
                            <label class="inline-flex items-center justify-between w-full p-5 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-100" for="cash">
                                <div>Pay at Appointment</div>
                            </label>
                        </li>
                    </ul>
                    @error('payment_method') <div class="text-sm text-red-500">{{ $message }}</div> @enderror

                    <button type="submit" class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                        <span wire:loading.remove>Confirm Booking</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
