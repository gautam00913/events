<div>
    <x-table>
        <x-slot name="thead">
            <tr>
                <x-th>#</x-th>
                <x-th>Nom de l'évènement</x-th>
                <x-th>Type de billet</x-th>
                <x-th>Prix Unitaire du billet</x-th>
                <x-th>Nombre de place</x-th>
                <x-th>Prix Total</x-th>
                <x-th>Date d'achat</x-th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach ($participations as $key => $event)
                <x-tr>
                    <x-td>
                      <div class="flex space-x-2 items-center">
                        <p>{{ $key +1 }}</p>
                        <a href="{{ route('tickets.download', ['ticket' => 'tk-'. '00-'. $event->id. '-'. $event->pivot->ticket->id. '-'. $user->id]) }}" title="Téléchargement du ticket">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                              </svg>
                        </a>
                      </div>
                    </x-td>
                    <x-td>{{ $event->title }}</x-td>
                    <x-td>{{ $event->pivot->ticket->name }}</x-td>
                    <x-td>{{ number_format($event->pivot->ticket->price, 2, '.', ' '). ' '. config('app.devise') }}</x-td>
                    <x-td>{{ $event->pivot->number_place }}</x-td>
                    <x-td>{{ number_format($event->pivot->total_amount, 2, '.', ' '). ' '. config('app.devise') }}</x-td>
                    <x-td>{{ $event->pivot->reserve_at->format('d/m/Y H:i') }}</x-td>
                   
                </x-tr>
            @endforeach
        </x-slot>

        <x-slot name="tfoot">
            <tr>
                <x-th colspan="4" class="text-center">Total</x-th>
                <x-th colspan="3" class="text-center">{{ number_format($participations->sum('pivot.total_amount'), 2, '.', ' '). ' '. config('app.devise') }}</x-th>
            </tr>
        </x-slot>
    </x-table>
</div>