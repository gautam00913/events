<div>
    <form action="{{ route('transactions.approuve', ['transaction' => $transaction->id]) }}">
        @csrf
        <div class="mb-3">
            Initiée par : <span class="font-bold ml-3">{{ $transaction->initiatedBy->name }}</span>
        </div>
        <div class="mb-3">
            Montant demandé : <span class="font-bold ml-3">{{ number_format($transaction->amount, 2, '.', ' '). ' '. config('app.devise') }}</span>
        </div>
        <div class="mb-3">
            Frais de gestion : <span class="font-bold ml-3">{{ number_format($fees_amount, 2, '.', ' '). ' '. config('app.devise') }}</span>
        </div>
        <div class="mb-3">
            Montant à envoyer : <span class="font-bold ml-3">{{ number_format($transaction->amount - $fees_amount, 2, '.', ' '). ' '. config('app.devise') }}</span>
        </div>
        <div class="mb-3">
            Nom du compte : <span class="font-bold ml-3">{{ $transaction->account_holder }}</span>
        </div>
        <div class="mb-3">
            Numéro du compte : <span class="font-bold ml-3">{{ $transaction->account_number }}</span>
        </div>
        <div class="mb-3">
            Type de compte : <span class="font-bold ml-3">{{ $transaction->account_provider }}</span>
        </div>
        <div class="mt-5 flex justify-center">
            <x-button type="submit">Valider</x-button>
        </div>
    </form>
</div>