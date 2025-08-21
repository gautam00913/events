<x-app-layout>
    <x-slot name="title">Validation du billet électronique</x-slot>
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            Validité du billet électronique
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
    </x-slot>
   
  <div>
        <div class="max-w-7xl md:max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-3">
                @if ($buyer_ticket->id === $ticket->id)
                    <div class="flex flex-col md:flex-row md:space-x-3 space-y-3 md:space-y-0 ">
                        <div class="h-40 w-40 mx-auto p-1 md:p-0 md:m-0 md:border-0 border border-purple-600 rounded-full md:h-auto md:w-1/3 md:rounded-none">
                            @if ($buyer->image)
                                <img src="{{ Storage::url($buyer->image) }}" alt="Avatar de {{ $buyer->name }}" class="w-full h-full rounded-full md:rounded-none object-center" />
                            @else
                                <img src="{{ asset('images/avatar.png') }}" alt="default avatar" class="w-full h-full rounded-full md:rounded-none object-center" />
                            @endif  
                        </div>
                        <div class="px-3 md:px-0">
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Reservé sous le nom :</span>
                                <span class="italic">{{ $buyer->name }}</span>
                            </p>
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Date de réservation :</span>
                                <span class="italic">{{ $buyer->pivot->reserve_at->format('d/m/Y H:i') }}</span>
                            </p>
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Statut du billet :</span>
                                @if ($buyer->pivot->scanned == 0)
                                    <span class="italic text-white px-3 py-1 bg-green-500 rounded">Valide</span>
                                @elseif ($buyer->pivot->scanned == 1)
                                    <span class="italic text-white px-3 py-1 bg-yellow-400 rounded">Valide, déjà scanné</span>
                                @else
                                    <span class="italic text-white px-3 py-1 bg-red-500 rounded">Non valide !</span>
                                @endif
                            </p>
                            @if ($buyer->pivot->scanned == 1 && $buyer->pivot->scanned_at)
                                <p class="mb-3">
                                    <span class="font-bold underline text-xl mr-3">Date de scannage :</span>
                                    <span class="italic">{{ $buyer->pivot->scanned_at->format('d/m/Y H:i') }}</span>
                                </p>
                            @endif
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Nombre de place :</span>
                                <span class="italic">{{ $buyer->pivot->number_place }}</span>
                            </p>
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Nom de l'évènement :</span>
                                <span class="italic">{{ $event->title }}</span>
                            </p>
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Nom du billet :</span>
                                <span class="italic">{{ $ticket->name }}</span>
                            </p>
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Montant payé :</span>
                                <span class="italic">
                                    {{ number_format($ticket->pivot->price, 2, '.', ' '). ' '. config('app.devise') .' x '. $buyer->pivot->number_place .' = ' }}
                                    <b>{{ number_format($buyer->pivot->total_amount, 2, '.', ' '). ' '. config('app.devise')  }}</b>
                                </span>
                            </p>
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Organisateur :</span>
                                <span class="italic">{{ $event->user->name }}</span>
                            </p>
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Date de début :</span>
                                <span class="italic">{{ $event->starts_at->format('d/m/Y H:i') }}</span>
                            </p>
                            @if ( $event->ends_at)
                                <p class="mb-3">
                                    <span class="font-bold underline text-xl mr-3">Date de fin :</span>
                                    <span class="italic">{{ $event->ends_at->format('d/m/Y H:i') }}</span>
                                </p>
                            @endif
                            <p class="mb-3">
                                <span class="font-bold underline text-xl mr-3">Contact du client :</span>
                                <span class="italic">
                                    {{ $buyer->email }}
                                    @if ($buyer->phone)
                                        / {{ $buyer->phone }}
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="text-center bg-red-300 text-red-700 py-6 px-3">
                        <p>
                            Billet Invalide !
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
