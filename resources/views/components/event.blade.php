<div class="{{ $event->premium ? 'bg-blue-200' : 'bg-white' }} rounded-lg shadow-md hover:shadow-xl">
    <div class="relative">
        @if ($event->image)
            <img src="{{ Storage::url($event->image) }}" class="h-64 object-center object-cover w-full transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" alt="flyers for event {{ $event->title }}">
        @else
            <img src="{{ asset('images/default.png') }}" class="h-64 object-center object-cover w-full" alt="default image">
        @endif
        <p class="bg-yellow-500 px-2 py-1 rounded absolute top-1 left-1">
            prix à parti de 
            {{ $event->tickets->min(function($ticket){
                return $ticket->pivot->price;
            }).' '. config('app.devise')}}
        </p>
    </div>
    <div class="flex space-x-5 mt-3 px-3">
        <div>
            <div class="flex space-x-3 flex-start {{ $event->premium ? 'bg-yellow-200' : 'bg-blue-100' }} p-1">
                <div class="leading-none ">
                    <p class="text-gray-500 pb-2 mb-2 border-b border-blue-600">{{ $event->starts_at->translatedFormat('M') }}</p>
                    <p class="text-gray-800 font-medium title-font text-lg leading-none">{{ $event->starts_at->translatedFormat('d') }}</p>
                </div>
                <div class="leading-none">
                    <p class="text-gray-500 pb-2 mb-2 border-b border-blue-600">{{ $event->ends_at ? $event->ends_at->translatedFormat('M') : '' }}</p>
                    <p class="text-gray-800 font-medium title-font text-lg leading-none">{{ $event->ends_at ? $event->ends_at->translatedFormat('d') : '' }}</p>
                </div>
            </div>
        </div>
        <div>
            <h3 class="title-font text-xs tracking-widset text-indigo-500 inline-block mb-1">
                @foreach ($event->tags as $tag)
                    {{ $tag->name }}{{ $loop->last ? '': ',' }}
                @endforeach
            </h3>
            <h2 class="text-lg md:text-xl font-bold text-gray-700 title-font mb-3">{{ $event->title }}</h2>
            <div class="leading-relaxed mb-5">
                {{ $event->content }}
            </div>
            <a class="inline-flex items-center "href="#">
                <img src="{{ asset('/images/avatar.png') }}" class="w-8 h-8 rounded-full object-center object-cover flex-shrink-0" alt="...">
                <span class="flex flex-grow flex-col pl-6">
                    <span class="title-font font-medium text-gray-900 italic">
                        {{ $event->user->name }}
                    </span>
                </span>
            </a>
            @php
                $place = $event->tickets->sum(function($ticket){
                return $ticket->pivot->remaining_place;
            });
            @endphp
            <p class="italic text-purple-600 py-3">
                <span class="font-bold">{{ $place }}</span>
                {{ Str::plural("place", $place).' ' .Str::plural("restante", $place) }}
            </p>
            <x-button class="mb-4" type="button">Prendre de ticket</x-button>
        </div>
    </div>
</div>