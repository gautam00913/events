@component('mail::message')
## Bonjour cher/ chère {{ $buyer->name }}


**{{ $event->user->name }}** vient de scanner votre billet **{{ $ticket->name }}**
de l'évènement **[{{ $event->title }}]({{ route('events.index'). '?event='. $event->id }})**
le **{{ $scanned_at }}**.

Nous vous remercions pour votre accord de confiance à [**E-events**]({{ route('home') }}), et d'avoir participé
à cet évènement.


Nous serions ravi de vous compter parmi les prochains participants.

@component('mail::button', ['url' => route('events.index'), 'color' => 'purple'])
Participez à d'autres évènements
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
