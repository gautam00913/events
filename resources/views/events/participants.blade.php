<div>
    <x-table>
        <x-slot name="thead">
            <tr>
                <x-th>#</x-th>
                <x-th>Nom du participant</x-th>
                <x-th>Type de billet</x-th>
                <x-th>Prix Unitaire du billet</x-th>
                <x-th>Nombre de place</x-th>
                <x-th>Prix Total</x-th>
                <x-th>Date d'achat</x-th>
            </tr>
        </x-slot>
        <x-slot name="tbody">
            @foreach ($participants as $key => $participant)
                <x-tr>
                    <x-td>
                      <div class="flex space-x-2 items-center">
                        <p>{{ $key +1 }}</p>
                      </div>
                    </x-td>
                    <x-td>{{ $participant->name }}</x-td>
                    <x-td>{{ $participant->pivot->ticket->name }}</x-td>
                    <x-td>{{ number_format($participant->pivot->ticket->price, 2, '.', ' '). ' '. config('app.devise') }}</x-td>
                    <x-td>{{ $participant->pivot->number_place }}</x-td>
                    <x-td>{{ number_format($participant->pivot->total_amount, 2, '.', ' '). ' '. config('app.devise') }}</x-td>
                    <x-td>{{ $participant->pivot->reserve_at->format('d/m/Y H:i') }}</x-td>
                   
                </x-tr>
            @endforeach
        </x-slot>

        <x-slot name="tfoot">
            <tr>
                <x-th colspan="4" class="text-center">Total</x-th>
                <x-th colspan="3" class="text-center">{{ number_format($participants->sum('pivot.total_amount'), 2, '.', ' '). ' '. config('app.devise') }}</x-th>
            </tr>
        </x-slot>
    </x-table>
</div>