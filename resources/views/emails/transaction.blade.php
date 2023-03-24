@component('mail::message')
# Bonjour l'administration de {{ config('app.name') }}

L'utilisateur **{{ $user->name }}** a fait une demande de virement
de **{{ number_format($transaction->amount, 2, '.', ' '). ' '. config('app.devise') }}**
vers son compte mobile money({{ $transaction->account_provider }}).

Connectez-vous pour approuver cette transaction.

@component('mail::button', ['url' => route('dashboard'), 'color' => 'purple'])
Se connecter
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
