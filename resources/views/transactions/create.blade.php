<div>
    <form action="{{ route('transactions.insert') }}" method="POST" id="insertTransactionForm">
        @csrf
        <div class="mb-3">
            <x-label for="account_provider" value="Type de compte"></x-label>
            <x-select type="text" name="account_provider" id="account_provider" class="w-full" required>
                <option value="">---------</option>
                <option value="MTN-BJ">MTN Bénin Mobile Money</option>
                <option value="MOOV-BJ">Moov Money</option>
            </x-select>
        </div>
        <div class="mb-3">
            <x-label for="account_holder" value="Nom du compte"></x-label>
            <x-input type="text" name="account_holder" class="w-full" id="account_holder" :value="$user->name"></x-input>
        </div>
        <div class="mb-3">
            <x-label for="account_number" value="Numéro du compte"></x-label>
            <x-input type="tel" name="account_number" class="w-full" id="account_number" :value="$user->phone"></x-input>
        </div>
        <div class="mb-3">
            <x-label for="amount" value="Montant à retirer"></x-label>
            <x-input type="number" name="amount" class="w-full" id="amount" min="100"></x-input>
        </div>
        <div class="mt-5 flex justify-center">
            <x-button>Valider</x-button>
        </div>
    </form>
</div>