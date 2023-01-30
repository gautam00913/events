<div class="{{ $event->premium ? 'bg-blue-200' : 'bg-white' }} rounded-lg shadow-md hover:shadow-2xl transition ease-linear delay-300 hover:shadow-yellow-500">
    <div class="h-full flex flex-col justify-between ">
        <div>
            <div class="relative">
                @if ($event->image)
                    <img src="{{ Storage::url($event->image) }}" class="flyers h-64 object-center object-cover w-full transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" alt="flyers for event {{ $event->title }}">
                @else
                    <img src="{{ asset('images/default.png') }}" class="flyers h-64 object-center object-cover w-full" alt="default image">
                @endif
                <p class="bg-yellow-500 px-2 py-1 rounded absolute top-1 left-1">
                   créé le {{ $event->created_at->format('d/m/Y \à H:i') }}
                </p>
            </div>
            <div class="grid grid-flow-row-dense grid-cols-12 mt-3 px-3">
                <div class="col-span-3">
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
                <div class="col-span-8 ml-4">
                    <h3 class="title-font text-xs tracking-widset text-indigo-500 inline-block mb-1">
                        @foreach ($event->tags as $tag)
                            {{ $tag->name }}{{ $loop->last ? '': ',' }}
                        @endforeach
                    </h3>
                </div>
            </div>
            <div class="p-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-700 title-font mb-3 event_title" id="{{ $event->id }}">{{ $event->title }}</h2>
                <div class="leading-relaxed mb-5">
                    {{ $event->content }}
                </div>
            </div>
        </div>
        <div class="px-3 mb-3 border-y py-1">
            <ul>
                @foreach ($event->tickets as $ticket)
                    <ol><span class="font-semibold">{{ $ticket->name. '('. number_format($ticket->pivot->price, 2, '.', ' ') . ' ' . config('app.devise') . ')' }} : </span> {{ $ticket->pivot->remaining_place. '/'. $ticket->pivot->total_place }}</ol>
                @endforeach
            </ul>
        </div>
        <div class="flex items-center mb-4 justify-between px-3">
            <x-button class="editEvent" :data-url="route('events.edit', $event->id)" type="button">Modifier</x-button>
            <x-button class="deleteEvent" :data-url="route('events.destroy', $event->id)" :data-name="$event->title" type="button">Supprimer</x-button>
        </div>
    </div>
</div>