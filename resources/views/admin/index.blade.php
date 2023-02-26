<x-app-layout>

    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            Tableau d'administration
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
    </x-slot>
    <x-slot name="title">Tableau d'administration</x-slot>
   
  <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pb-10">
                <div class="mb-4 md:mb-6 p-6 bg-white border-b border-gray-200">
                    <div class="inline-block mb-3">
                        <h3 class="peer font-semibold text-lg text-purple-800 hover:text-yellow-500 leading-tight">
                            Historique des demandes de virements
                        </h3>
                        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
                    </div>
                    <div>
                        <x-table>
                            <x-slot name="thead">
                                <tr>
                                    <x-th>#</x-th>
                                    <x-th>Initié par</x-th>
                                    <x-th>Date de demande</x-th>
                                    <x-th>Montant demandé</x-th>
                                    <x-th>Statut</x-th>
                                    <x-th>Nom du compte</x-th>
                                    <x-th>Numéro du compte</x-th>
                                    <x-th>Frais de Gestion</x-th>
                                    <x-th>Montant remboursé</x-th>
                                    <x-th>Date de remboursement</x-th>
                                </tr>
                            </x-slot>
                            <x-slot name="tbody">
                                @forelse ($transactions as $key => $transaction)
                                    <x-tr>
                                        <x-td>
                                          <div class="flex space-x-2 items-center">
                                            <p>{{ $key +1 }}</p>
                                            
                                          </div>
                                        </x-td>
                                        <x-td>{{ $transaction->initiatedBy->name }}</x-td>
                                        <x-td>{{ $transaction->initiate_at->format('d/m/Y H:i') }}</x-td>
                                        <x-td>{{ number_format($transaction->amount, 2, '.', ' '). ' '. config('app.devise') }}</x-td>
                                        <x-td>
                                            @if ($transaction->refunded_at)
                                                <p class="bg-green-500 px-3 py-1 text-white">Remboursé</p>
                                            @else
                                                <p class="bg-yellow-400 px-3 py-1 text-white">En cours</p>
                                            @endif
                                        </x-td>
                                        <x-td>{{ $transaction->account_holder }}</x-td>
                                        <x-td>{{ $transaction->account_number }}</x-td>
                                        <x-td>{{ number_format($transaction->fees_amount, 2, '.', ' '). ' '. config('app.devise') }}</x-td>
                                        <x-td>{{ number_format($transaction->refunded_amount, 2, '.', ' '). ' '. config('app.devise') }}</x-td>
                                        <x-td>{{ $transaction->refunded_at ? $transaction->refunded_at->format('d/m/Y H:i') : '-' }}</x-td>
                                       
                                    </x-tr>
                                @empty
                                <x-tr>
                                    <x-td colspan="10" class="text-center text-xl">Aucune donnée disponible</x-td>
                                </x-tr>
                                @endforelse
                            </x-slot>
                    
                            <x-slot name="tfoot">
                                <tr>
                                    <x-th colspan="3" class="text-center">Total</x-th>
                                    <x-th colspan="2" class="text-left">{{ number_format($transactions->sum('amount'), 2, '.', ' '). ' '. config('app.devise') }}</x-th>
                                    <x-th colspan="2" >&nbsp;</x-th>
                                    <x-th class="text-left">{{ number_format($transactions->sum('fees_amount'), 2, '.', ' '). ' '. config('app.devise') }}</x-th>
                                    <x-th colspan="2" class="text-left">{{ number_format($transactions->sum('refunded_amount'), 2, '.', ' '). ' '. config('app.devise') }}</x-th>
                                </tr>
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
