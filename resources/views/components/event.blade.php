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
                    @php 
                        $min_ticket = $event->tickets->min(function($ticket){
                            return $ticket->pivot->price;
                        }); 
                    @endphp
                    @if ($min_ticket == 0 && $event->tickets->count() == 1)
                        Evènement gratuit
                    @else
                        Billet à parti de 
                        {{ number_format($min_ticket, 2, '.', ' ') .' '. config('app.devise')}}
                    @endif
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
        <div class="text-center">
            <a class="inline-flex items-center"href="#">
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
            <div class="hidden event_tickets">
                <div class="flex items-center mb-3 space-x-3">
                   <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>
                        <p class="ml-2">Date de début : </p>
                   </div>
                    <div>{{ $event->starts_at->format('d/m/Y H:i') }}</div>                      
                </div>
                @if ($event->ends_at)
                    <div class="flex items-center mb-3 space-x-3">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>
                            <p class="ml-2">Date de fin : </p>
                        </div>
                        <div>{{ $event->ends_at->format('d/m/Y H:i') }}</div>                      
                    </div>
                @endif
                @foreach ($event->tickets as $ticket)
                    <x-input type="hidden" class="ticket_prices" :value="$ticket->pivot->price" ></x-input>
                    <div class="flex items-center mb-3 space-x-4">
                            <x-input type="checkbox" name="tickets[]" :value="$ticket->pivot->id" id="ticket_{{ $ticket->pivot->id }}" :checked="$loop->first"></x-input>
                            <x-label :value="$ticket->name" for="ticket_{{ $ticket->pivot->id }}"/>
                            <p class="text-purple-600">{{ number_format($ticket->pivot->price, 2, '.', ' '). ' '. config('app.devise') }}</p>
                    </div>
                    <div class="mb-3 @if(!$loop->last) border-b pb-3 @endif">
                        <x-label value="Nombre de place" for="number_place_ticket_{{ $ticket->pivot->id }}"/>
                            <x-input min="1" :value="1" name="number_places[]" type="number" id="number_place_ticket_{{ $ticket->pivot->id }}"/>
                    </div>
                @endforeach
            </div>
            <x-button class="mb-4 buyTicket" :disabled="$place === 0" type="button">Prendre de ticket</x-button>
        </div>
    </div>
</div>