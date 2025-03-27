<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="container mx-auto px-4">
    <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
    <div class="flex flex-col md:flex-row gap-4">
      <!-- Cart Items Section -->
      <div class="w-full md:w-3/4">
        <!-- Desktop Table Layout -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-4 overflow-x-auto md:block hidden">
          <table class="w-full min-w-[600px]">
            <thead>
              <tr>
                <th class="text-left font-semibold">Product</th>
                <th class="text-left font-semibold">Price</th>
                <th class="text-left font-semibold">Quantity</th>
                <th class="text-left font-semibold">Total</th>
                <th class="text-left font-semibold">Remove</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($cart_items as $item)
              <tr wire:key="{{$item['product_id']}}">
                <td class="py-4">
                  <div class="flex items-center">
                    <img class="h-16 w-16 mr-4" src="{{url('storage', $item['image'])}}" alt="Product image">
                    <span class="font-semibold">{{$item['name']}}</span>
                  </div>
                </td>
                <td class="py-4">${{number_format($item['unit_amount'], 0)}}</td>
                <td class="py-4">
                  <div class="flex items-center">
                    <button wire:click='decreaseQty({{ $item["product_id"] }})'
                      wire:loading.attr="disabled"
                      class="border border-gray-400 rounded-md w-8 h-8 flex items-center justify-center hover:bg-green-500 hover:text-white">
                      -
                    </button>
                    <span class="text-center w-8">{{ $item["quantity"] }}</span>
                    <button wire:click='increaseQty({{ $item["product_id"] }})'
                      wire:loading.attr="disabled"
                      class="border border-gray-400 rounded-md w-8 h-8 flex items-center justify-center hover:bg-green-500 hover:text-white">
                      +
                    </button>
                  </div>
                </td>
                <td class="py-4">${{number_format($item['total_amount'], 0)}}</td>
                <td>
                  <button wire:click="removeItem({{ $item['product_id'] }})"
                    class="bg-slate-300 border-2 border-slate-400 rounded-lg px-3 py-1 hover:bg-red-500 hover:text-white hover:border-green-700">
                    Remove
                  </button>
                </td>
              </tr>
              @empty
              <td colspan="5" class="text-center py-4 text-4xl text-slate-500 font-semibold">No items available in cart!</td>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Mobile Card Layout -->
        <div class="md:hidden">
          <div class="space-y-4">
            @forelse ($cart_items as $item)
            <div wire:key="{{$item['product_id']}}" class="p-4 border rounded-lg shadow-sm bg-gray-50">
              <!-- First Row: Product Image and Name (Same Row Now) -->
              <div class="flex items-center gap-4">
                <img class="h-16 w-16 object-cover rounded" src="{{url('storage', $item['image'])}}" alt="Product image">
                <span class="font-semibold text-md">{{$item['name']}}</span>
              </div>
              
              <!-- Second Row: Price and Quantity Controls -->
              <div class="flex justify-between items-center mt-3">
                <span class="text-gray-700 font-medium">${{number_format($item['unit_amount'], 0)}}</span>
                <div class="flex items-center space-x-2">
                  <button wire:click='decreaseQty({{ $item["product_id"] }})'
                    wire:loading.attr="disabled"
                    class="border border-gray-400 rounded-md w-8 h-8 flex items-center justify-center hover:bg-green-500 hover:text-white">
                    -
                  </button>
                  <span class="text-center w-8">{{ $item["quantity"] }}</span>
                  <button wire:click='increaseQty({{ $item["product_id"] }})'
                    wire:loading.attr="disabled"
                    class="border border-gray-400 rounded-md w-8 h-8 flex items-center justify-center hover:bg-green-500 hover:text-white">
                    +
                  </button>
                </div>
              </div>
              
              <!-- Third Row: Total and Remove Button -->
              <div class="flex justify-between items-center mt-3">
                <span class="text-gray-900 font-semibold">Total: ${{number_format($item['total_amount'], 0)}}</span>
                <button wire:click="removeItem({{ $item['product_id'] }})"
                  class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">
                  Remove
                </button>
              </div>
            </div>
            @empty
            <div class="text-center py-4 text-2xl text-gray-500 font-semibold">No items available in cart!</div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Summary Section -->
      <div class="w-full md:w-1/4">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-lg font-semibold mb-4">Summary</h2>
          <div class="flex justify-between mb-2">
            <span>Subtotal</span>
            <span>${{number_format($grand_total, 0)}}</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>Shipping</span>
            <span>${{number_format(0, 2)}}</span>
          </div>
          <hr class="my-2">
          <div class="flex justify-between mb-2">
            <span class="font-semibold">Total</span>
            <span class="font-semibold">${{number_format($grand_total, 0)}}</span>
          </div>
          @if ($cart_items)
          <a href="/checkout" class="bg-green-500 text-white block text-center py-2 px-4 rounded-lg mt-4 w-full">
            Checkout
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
