<section class="py-12">
    <div class="max-w-xl mx-auto">
        <div class="text-center">
            <div class="relative flex flex-col items-center">
                <h1 class="text-4xl font-bold">Browse Popular <span class="text-green-500">Brands</span></h1>
                <div class="flex w-40 mt-2 mb-4 overflow-hidden rounded">
                    <div class="flex-1 h-2 bg-green-200"></div>
                    <div class="flex-1 h-2 bg-green-400"></div>
                    <div class="flex-1 h-2 bg-green-600"></div>
                </div>
            </div>
            <p class="mb-8 text-base text-center text-gray-500">
              Discover top-tier tennis gear from the most trusted brands in the sport. Whether you're looking for high-performance rackets, durable strings, or comfortable apparel, we've got you covered with the best selections.
          </p>
        </div>
    </div>
    <div class="justify-center max-w-6xl px-4 py-4 mx-auto lg:py-0">
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($brands as $brand)
                <div class="bg-white rounded-lg shadow-md mb-2 p-2" wire:key="{{$brand->id}}">
                    <a href="/products?selected_brands[0]={{$brand->id}}">
                        <img src="{{asset('storage/' . $brand->image)}}" alt="{{$brand->name}}" class="object-cover w-full h-32 sm:h-40 rounded-t-lg">
                    </a>
                    <div class="p-2 text-center">
                        <a href="" class="text-lg font-semibold tracking-tight text-gray-900">
                            {{$brand->name}}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
  </section>
  