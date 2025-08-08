<div class="{{ $event->premium ? 'bg-blue-200' : 'bg-white' }} rounded-lg shadow-md hover:shadow-2xl transition ease-linear delay-300 hover:shadow-yellow-500">
    <div class="h-full flex flex-col justify-between ">
        <div>
            <div class="relative">
                @if ($event->image)
                    <img src="{{ Storage::url($event->image) }}" class="flyers h-64 object-center object-fill w-full transition-all duration-300 cursor-pointer filter grayscale hover:grayscale-0" alt="flyers for event {{ $event->title }}">
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
        <div class="flex items-center mb-4 justify-center px-3">
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <x-button class="flex items-center text-sm font-medium hover:border-yellow-300 focus:outline-none focus:border-yellow-300 transition duration-150 ease-in-out">
                        <div>Action</div>

                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            </svg>
                        </div>
                    </x-button>
                </x-slot>

                <x-slot name="content">
                    <div class="divide-y">
                        <x-dropdown-link class="eventParticipants cursor-pointer flex items-center"  :data-url="route('events.participants', $event->id)" :data-event="$event->title">
                            Liste des Participants
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </x-dropdown-link>
                        <x-dropdown-link class="editEvent cursor-pointer flex items-center"  :data-url="route('events.edit', $event->id)">
                            Modifier
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </x-dropdown-link>
                        <x-dropdown-link class="deleteEvent cursor-pointer flex items-center"  :data-url="route('events.destroy', $event->id)" :data-name="$event->title">
                            Supprimer
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </x-dropdown-link>
                        <x-dropdown-link class="shareEvent cursor-pointer flex items-center"  :data-slug="$event->slug" :data-event="$event->title">
                            Partager
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                            </svg>
                              
                        </x-dropdown-link>
                   </div>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>