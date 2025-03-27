<header class="flex z-50 sticky top-0 flex-wrap md:justify-start md:flex-nowrap w-full bg-white text-sm py-3 md:py-0 shadow-md">
  <nav class="max-w-[85rem] w-full mx-auto px-4 md:px-6 lg:px-8" aria-label="Global">
    <div class="relative md:flex md:items-center md:justify-between">
      
      <!-- Logo & Mobile Menu -->
      <div class="flex items-center justify-between w-full md:w-auto">
        <a wire:navigate class="text-xl font-bold text-gray-800" href="/" aria-label="Brand">gadjo</a>
        <div class="md:hidden">
          <button type="button" class="hs-collapse-toggle flex justify-center items-center w-9 h-9 text-gray-800 border border-gray-300 rounded-md hover:bg-gray-100"
            data-hs-collapse="#navbar-collapse-with-animation">
            ☰
          </button>
        </div>
      </div>

      <!-- Navigation -->
      <div id="navbar-collapse-with-animation" class="hs-collapse hidden transition-all duration-300 basis-full grow md:block">
        <div class="flex flex-col md:flex-row md:items-center md:justify-end md:gap-x-7 md:ps-7">
          
          <!-- Navigation Links -->
          <a wire:navigate class="font-medium {{ request()->is('/') ? 'text-orange-600' : 'text-gray-500 hover:text-gray-400' }} py-3 md:py-6" href="/">Home</a>
          
          <a wire:navigate class="font-medium {{ request()->is('categories') ? 'text-orange-600' : 'text-gray-500 hover:text-gray-400' }} py-3 md:py-6" href="/categories">Categories</a>
          
          <a wire:navigate class="font-medium {{ request()->is('products*') ? 'text-orange-600' : 'text-gray-500 hover:text-gray-400' }} py-3 md:py-6" href="/products">Products</a>
          
          <!-- Cart -->
          <a wire:navigate class="flex items-center font-medium {{ request()->is('cart') ? 'text-orange-600' : 'text-gray-500 hover:text-gray-400' }} py-3 md:py-6 transition duration-200" href="/cart">
            🛒 <span class="ml-1">Cart</span> 
            <span class="py-0.5 px-2 rounded-full text-xs font-medium bg-orange-100 text-orange-700 ml-2">{{$total_count}}</span>
          </a>

          <!-- Login & Dropdown -->
          <div class="relative flex items-center space-x-4">
            
            @guest
            <!-- Login Button -->
            <a wire:navigate class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-600 text-white hover:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none" href="/login">
              <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                  <circle cx="12" cy="7" r="4" />
              </svg>
              Log in
          </a>
            @endguest

            @auth
            <!-- Account Dropdown -->
            <div x-data="{ open: false }" class="relative">
              
              <!-- Dropdown Toggle Button -->
              <button @click="open = !open" class="flex items-center py-2.5 px-5 text-sm font-semibold rounded-lg border border-gray-300 bg-white hover:bg-gray-100 transition duration-200">
                {{auth()->user()->name}}  ⌄
              </button>
              
              <!-- Dropdown Content -->
              <div x-show="open" @click.away="open = false"
                class="absolute top-full left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50 overflow-hidden transition-all duration-200">
                {{-- <a wire:navigate href="" class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition">👤 Profile</a>
                <a wire:navigate href="/settings" class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition">⚙️ Settings</a> --}}
                <a wire:navigate href="/my-orders" class="block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition">📦 My Orders</a>
                <a wire:navigate href="/logout" class="block px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition">🚪 Logout</a>
              </div>

            </div>
            @endauth

          </div>

        </div>
      </div>

    </div>
  </nav>
</header>
