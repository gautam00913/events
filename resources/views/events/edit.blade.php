<div>
    <form action="{{ route('events.update', $event->id) }}" method="POST" id="addEventForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="my-3">
                <x-label  for="title" >
                    Titre de l'évènement <span class='text-red-600'>*</span>
                </x-label>
                <x-input id="title" name="title" :value="$event->title" class="w-full" type="text" required />
            </div>
            <div class="my-3">
                <x-label  for="content" >
                    Description <span class='text-red-600'>*</span>
                </x-label>
                <textarea id="content" name="content" class="text-purple-500 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ $event->content }} </textarea>
            </div>
            <div class="my-3">
                <x-label  for="premium" value="Premium ?" />
                <x-input id="premium" name="premium" value="1" type="checkbox" @if($event->premium) checked @endif />
            </div>
            <div class="my-3">
                <x-label  for="content" >
                    Date de début <span class='text-red-600'>*</span>
                </x-label>
                <x-input id="starts_at" name="starts_at" :value="$event->starts_at" class="w-full" type="datetime-local" required/>
            </div>
            <div class="my-3">
                <x-label  for="ends_at" value="Date de fin" />
                <x-input id="ends_at" name="ends_at" :value="$event->ends_at" class="w-full" type="datetime-local" />
            </div>
            <div class="my-3">
                <x-label  for="tags" value="Mots clés séparé par des virgules" />
                <x-input id="tags" name="tags" :value="$event->formatTags" class="w-full" type="text" />
            </div>
            <div class="my-3">
                <x-label  for="image" value="Flyers de l'évènement" />
                <x-input id="image" name="image" :value="$event->image" class="w-full" type="file" />
            </div>
            <div class="my-3">
                <x-label  for="ticket_number" value="Nombre de billets" />
                <x-input id="ticket_number" name="ticket_number" :value="$event->tickets->count()" class="w-full" type="number" min="1" max="5" />
            </div>
            @foreach ($event->tickets as $key => $ticket)
                <fieldset class="border px-4 py-2">
                    <legend>Billet n° {{ $key +1 }}</legend>
                    <div class="tickets">
                        <div class="my-3 flex items-center">
                            <x-label  for="ticket_name_{{ $key +1 }}" class="mr-3">
                                Nom du billet <span class='text-red-600'>*</span>
                            </x-label>
                        <div class="flex-1 flex">
                            <x-select id="ticket_name_{{ $key +1 }}" name="ticket_name[]" class="flex-1 rounded-md rounded-r-none border-r-0 tickets_option" required>
                                <option value="" selected>--- Choisir ---</option>
                                @foreach ($tickets as $tick)
                                    <option value="{{ $tick->id }}" @selected($tick->id === $ticket->id)>{{ $tick->name }}</option>
                                @endforeach
                            </x-select>
                            <button data-id="ticket_name_{{ $key +1 }}" type="button" class="text-black border rounded-l-none rounded-md border-gray-300 addTicketBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                        </div>
                        <div class="my-3">
                            <x-label  for="ticket_price_{{ $key +1 }}">
                                Prix unitaire <span class='text-red-600'>*</span>
                            </x-label>
                            <x-input id="ticket_price_{{ $key +1 }}" :value="$ticket->pivot->price" name="ticket_price[]" class="w-full" type="number" required min="0"/>
                        
                        </div>
                        <div class="my-3">
                            <x-label  for="ticket_place_{{ $key +1 }}">
                                Nombre de place réservé <span class='text-red-600'>*</span>
                            </x-label>
                            <x-input id="ticket_place_{{ $key +1 }}" :value="$ticket->pivot->total_place" name="ticket_place[]" class="w-full" type="number" required min="0"/>
                        
                        </div>
                    </div>
                </fieldset>
            @endforeach
            <div class="mt-5 flex justify-center btn_create">
                <x-button id="updateEvent">Modifier l'évènement</x-button>
            </div>
    </form>
</div>
    <div id="addTicketModal" class="hidden w-full fixed min-h-screen top-0 left-0 z-50 bg-transparent" style="transition: opacity .15s linear; outline: 0;">
        <div class="relative top-5 w-11/12 md:w-1/2 mx-auto bg-white rounded-md px-3 py-2 shadow-2xl h-3/4 bg-clip-padding border border-gray-400 mb-3">
            <div class="flex justify-between items-center border-b border-gray-500">
                <h5 class="font-bold text-lg">Ajouter un nouveau Ticket</h5>
                <button onclick="$('#addTicketModal').toggleClass('hidden')" type="button" class="text-gray-600">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div>
                    <x-label  for="add_ticket_name" value="Nom du Billet" />
                    <x-input id="add_ticket_name" name="add_ticket_name" class="w-full mt-3" type="text" />
                    <input id="select_option" type="hidden" value="" />
                <p class="text-red italic error_ticket"></p>
                <div class="mt-5 flex justify-center">
                    <x-button id="AddTicket">Ajouter</x-button>
                </div>
            </div>
        </div>
    </div>