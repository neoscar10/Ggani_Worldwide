<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="py-10 bg-gray-50 font-poppins rounded-lg">
      <div class="px-4 py-4 mx-auto max-w-7xl lg:py-6 md:px-6">
        <div class="flex flex-wrap mb-24 -mx-3">
          <div class="w-full pr-2 lg:w-1/4 lg:block">
            <div class="p-4 mb-5 bg-white border border-gray-200">
              {{-- Display Categories --}}
              <h2 class="text-2xl font-bold "> Categories</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600"></div>
              <ul>
                
                @foreach ($categories as $category)
                <li class="mb-4" wire:key="{{$category->id}}">
                  <label for="" class="flex items-center  ">
                    <input wire:model.live="selected_categories" type="checkbox" id="{{$category->slug}}" value="{{$category->id}}" class="w-4 h-4 mr-2">
                    <span class="text-lg">{{$category->name}}</span>
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
            {{-- display brands --}}
            <div class="p-4 mb-5 bg-white border border-gray-200 ">
              <h2 class="text-2xl font-bold ">Brand</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 "></div>
              <ul>
                @foreach ($brands as $brand)
                  <li class="mb-4" wire:key="{{$brand->id}}">
                    <label for="" class="flex items-center ">
                      <input wire:model.live="selected_brands" type="checkbox" id="{{$brand->slug}}" value="{{$brand->id}}" class="w-4 h-4 mr-2">
                      <span class="text-lg ">{{$brand->name}}</span>
                    </label>
                  </li>
                @endforeach
               
              </ul>
            </div>
            {{-- NOT IN USE FOR NOW --}}
            {{-- <div class="p-4 mb-5 bg-white border border-gray-200 ">
              <h2 class="text-2xl font-bold ">Product Status</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 "></div>
              <ul>
                <li class="mb-4">
                  <label for="" class="flex items-center ">
                    <input type="checkbox" class="w-4 h-4 mr-2">
                    <span class="text-lg ">In Stock</span>
                  </label>
                </li>
                <li class="mb-4">
                  <label for="" class="flex items-center ">
                    <input type="checkbox" class="w-4 h-4 mr-2">
                    <span class="text-lg ">On Sale</span>
                  </label>
                </li>
              </ul>
            </div> --}}
  
            <div class="p-4 mb-5 bg-white border border-gray-200">
              <h2 class="text-2xl font-bold ">Price</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 "></div>
              <div>
                <div class="inline-block text-lg font-bold text-green-400 ">${{number_format($price_range, 0)}}</div>
                <input wire:model.live="price_range" type="range" class="w-full h-1 mb-4 bg-green-100 rounded appearance-none cursor-pointer" max="1000" value="500" step="10">
                <div class="flex justify-between ">
                  <span class="inline-block text-lg font-bold text-green-400 ">${{number_format(10, 0)}}</span>
                  <span class="inline-block text-lg font-bold text-green-400 ">${{number_format(1000, 0)}}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="w-full px-3 lg:w-3/4">
            <div class="px-3 mb-4">
              <div class="items-center justify-between hidden px-3 py-2 bg-gray-100 md:flex  ">
                <div class="flex items-center justify-between">
                  <select wire:model.live="sort" name="" class="block w-40 text-base bg-gray-100 cursor-pointer  ">
                    <option value="latest">Sort by latest</option>
                    <option value="price">Sort by Price</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="flex flex-wrap items-center ">
  
              
              {{-- PRODUCTS CARD --}}
              @foreach ($products as $product)
                <div class="w-full px-3 mb-6 sm:w-1/2 md:w-1/3" wire:key="{{$product->id}}">
                  <div class="border border-gray-300 ">
                    <div class="relative bg-gray-200">
                      <a href="/products/{{$product->slug}}" class="">
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{$product->name}}" class="object-cover w-full h-56 mx-auto ">

                      </a>
                    </div>
                    <div class="p-3 ">
                      <div class="flex items-center justify-between gap-2 mb-2">
                        <h3 class="text-xl font-medium ">
                          {{$product->name}}
                        </h3>
                      </div>
                      <p class="text-lg ">
                        <span class="text-green-600">$ {{number_format($product->price, 0)}}</span>
                      </p>
                    </div>
                    <div class="flex justify-center p-4 border-t border-gray-300 ">
    
                      <a wire:click.prevent="addToCart({{$product->id}})" href="#" class="text-gray-500 flex items-center space-x-2  hover:text-green-500 ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 bi bi-cart3 " viewBox="0 0 16 16">
                          <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                        </svg><span wire:loading.remove wire:target="addToCart({{$product->id}})">Add to Cart</span> <span wire:loading wire:target="addToCart({{ $product->id }})" class="flex items-center gap-2">Adding
                          <svg class="w-4 h-4 text-green-600 animate-spin inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3.5-3.5L12 0 7.5 4.5 12 9V5a8 8 0 01-8 8z"></path>
                        </svg>
                          
                      </span>  
                      </a>
    
                    </div>
                  </div>
                </div>
              @endforeach
  
            </div>
            <!-- pagination start -->
            <div class="flex justify-end mt-6">
              {{$products->links()}}
            </div>
            <!-- pagination end -->
          </div>
        </div>
      </div>
    </section>
  
  </div>