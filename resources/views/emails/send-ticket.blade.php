@component('mail::message')
## Bonjour cher/ chère {{ $buyer->name }}


Vous venez de prendre en ligne des billets pour l'évènement **[{{ $event->title }}]({{ route('events.index'). '?event='. $event->id }})**
organisé par **{{ $event->user->name }}**.

Montant total payé : **{{ number_format($total_amount, 2, '.', ' '). ' '. config('app.devise') }}**


Vos billets electroniques sont joints à cet email, téléchargez les et rejoignez votre évènement.
En cas de pête ou d'impossibilité à télécharger les billets, vous pouvez les télécharger
sur [votre tableau de bord]({{ route('dashboard') }}).

@component('mail::button', ['url' => route('events.index'), 'color' => 'purple'])
Participez à d'autres évènements
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
