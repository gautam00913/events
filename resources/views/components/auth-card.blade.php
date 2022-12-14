<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="animate-bounce md:animate-pulse">
        {{ $logo }}
    </div>

    <div class="w-1/4 rounded-lg bg-white px-2 py-1">
        <a href="{{ route('home') }}" class="text-purple-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
              </svg>
              <span class="ml-2">
                Acceuil
              </span>
        </a>
    </div>
    <div class="w-11/12 sm:max-w-md mt-6 px-6 py-4 bg-white shadow-2xl overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
