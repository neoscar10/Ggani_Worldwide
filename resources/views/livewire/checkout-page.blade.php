<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
	<h1 class="text-2xl font-bold text-gray-800  mb-4">
		Checkout
	</h1>
	{{-- <form method="POST" wire:submit.prevent="save(Object.fromEntries(new FormData($event.target)))">
    	<input name="username" class="w-full rounded-lg border py-2 px-3 ">
    	<input name="email" class="w-full rounded-lg border py-2 px-3 ">
    	<input name="phone" class="w-full rounded-lg border py-2 px-3 ">
    	<input name="password" class="w-full rounded-lg border py-2 px-3 ">
		<button class="">SUBMIT></button>
	</form> --}}
	<form wire:submit.prevent="placeOrder">
		<div class="grid grid-cols-12 gap-4">
			<div class="md:col-span-12 lg:col-span-8 col-span-12">
				<!-- Card -->
				<div class="bg-white rounded-xl shadow p-4 sm:p-7">
					<!-- Shipping Address -->
					<div class="mb-6">
						<h2 class="text-xl font-bold underline text-gray-700  mb-2">
							Shipping Address
						</h2>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-gray-700  mb-1" for="first_name">
									First Name
								</label>
								<input wire:model="first_name" class="w-full rounded-lg border py-2 px-3 @error('first_name') border-red-500
								@enderror " id="first_name" type="text">
								</input>
								@error('first_name')
									<div class="text-sm text-red-500">{{$message}}</div>
								@enderror
							</div>
							<div>
								<label class="block text-gray-700  mb-1" for="last_name">
									Last Name
								</label>
								<input wire:model="last_name" class="w-full rounded-lg border py-2 px-3    @error('last_name') border-red-500
								@enderror " id="last_name" type="text">
								</input>
								@error('last_name')
									<div class="text-sm text-red-500">{{$message}}</div>
								@enderror
							</div>
						</div>
						<div class="mt-4">
							<label class="block text-gray-700  mb-1" for="phone">
								Phone
							</label>
							<input wire:model="phone" class="w-full rounded-lg border py-2 px-3   @error('phone') border-red-500
								@enderror  " id="phone" type="text">
							</input>
							@error('phone')
									<div class="text-sm text-red-500">{{$message}}</div>
								@enderror
						</div>
						<div class="mt-4">
							<label class="block text-gray-700  mb-1" for="address">
								Street Address
							</label>
							<input wire:model="street_address" class="w-full rounded-lg border py-2 px-3 @error('street_address') border-red-500
								@enderror" id="address" type="text">
							</input>
							@error('street_address')
									<div class="text-sm text-red-500">{{$message}}</div>
								@enderror
						</div>
						<div class="mt-4">
							<label class="block text-gray-700  mb-1" for="city">
								City
							</label>
							<input wire:model="city" class="w-full rounded-lg border py-2 px-3   @error('city') border-red-500
								@enderror  " id="city" type="text">
							</input>
							@error('city')
									<div class="text-sm text-red-500">{{$message}}</div>
								@enderror
						</div>
						<div class="grid grid-cols-2 gap-4 mt-4">
							<div>
								<label class="block text-gray-700  mb-1" for="state">
									State
								</label>
								<input wire:model="state" class="w-full rounded-lg border py-2 px-3   @error('state') border-red-500
								@enderror  " id="state" type="text">
								</input>
								@error('state')
									<div class="text-sm text-red-500">{{$message}}</div>
								@enderror
							</div>
							<div>
								<label class="block text-gray-700  mb-1" for="email">
									Email address(Optional)
								</label>
								<input wire:model="email" class="w-full rounded-lg border py-2 px-3   @error('email') border-red-500
								@enderror  " id="zip" type="text">
								</input>
								@error('email')
									<div class="text-sm text-red-500">{{$message}}</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="text-lg font-semibold mb-4">
						Select Payment Method
					</div>
					<ul class="grid w-full gap-6 md:grid-cols-2">
						<li>
							<input wire:model="payment_method" class="hidden peer" id="hosting-small" required="" type="radio" value="cod" />
							<label class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-orange-600 peer-checked:text-orange-600 hover:text-gray-600 hover:bg-gray-100 " for="hosting-small">
								<div class="block">
									<div class="w-full text-lg font-semibold">
										Cash on Delivery
									</div>
								</div>
								<svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
									</path>
								</svg>
							</label>
						</li>
						<li>
							<input wire:model="payment_method" class="hidden peer" id="hosting-big" type="radio" value="stripe">
							<label class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer  peer-checked:border-orange-600 peer-checked:text-orange-600 hover:text-gray-600 hover:bg-gray-100" for="hosting-big">
								<div class="block">
									<div class="w-full text-lg font-semibold ">
										Stripe
									</div>
								</div>
								<svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewbox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
									</path>
								</svg>
							</label>
							</input>
						</li>
					</ul>
					@error('payment_method')
									<div class="text-sm text-red-500">{{$message}}</div>
								@enderror
				</div>
				<!-- End Card -->
			</div>
			<div class="md:col-span-12 lg:col-span-4 col-span-12">
				<div class="bg-white rounded-xl shadow p-4 sm:p-7">
					<div class="text-xl font-bold underline text-gray-700  mb-2">
						ORDER SUMMARY
					</div>
					<div class="flex justify-between mb-2 font-bold">
						<span>
							Subtotal
						</span>
						<span>
							₦{{number_format($grand_total, 0)}}
						</span>
					</div>
					{{-- <div class="flex justify-between mb-2 font-bold">
						<span>
							Taxes
						</span>
						<span>
							0.00
						</span>
					</div> --}}
					<div class="flex justify-between mb-2 font-bold">
						<span>
							Shipping Cost
						</span>
						<span>
							0.00
						</span>
					</div>
					<hr class="bg-slate-400 my-4 h-1 rounded">
					<div class="flex justify-between mb-2 font-bold">
						<span>
							Grand Total
						</span>
						<span>
							₦{{number_format($grand_total, 0)}}
						</span>
					</div>
					</hr>
				</div>
				<button type="submit" class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
					<span wire:targer='placeOrder' wire:loading.remove>Place Order</span> <span wire:loading>Processing Order...</span>
				</button>
				<div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 ">
					<div class="text-xl font-bold underline text-gray-700  mb-2">
						SHOPPING SUMMARY
					</div>
					<ul class="divide-y divide-gray-200 " role="list">
						@foreach ($cart_items as $item)
							<li class="py-3 sm:py-4" wire:key="{{$item['product_id']}}">
								<div class="flex items-center">
									<div class="flex-shrink-0">
										<img alt="Neil image" class="w-12 h-12 rounded-full" src="{{url('storage', $item['image'])}}">
										</img>
									</div>
									<div class="flex-1 min-w-0 ms-4">
										<p class="text-sm font-medium text-gray-900 truncate ">
											{{$item['name']}}
										</p>
										<p class="text-sm text-gray-500 truncate">
											Quantity: {{$item['quantity']}}
										</p>
									</div>
									<div class="inline-flex items-center text-base font-semibold text-gray-900 ">
										₦{{number_format($item['total_amount'], 0)}}
									</div>
								</div>
							</li>
						@endforeach
						
					</ul>
				</div>
			</div>
		</div>
	</form>
</div>