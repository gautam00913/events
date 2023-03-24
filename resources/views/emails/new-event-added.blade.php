@component('mail::message')
# Bonjour l'administration de {{ config('app.name') }}

L'évènement [**{{ $event->title }}**](route('events.index', ["event" => $event->id])) vient d'être ajouté sur le site
par **{{ $organizer->name }}**.

@component('mail::button', ['url' => route('events.index', ["event" => $event->id]), 'color' => 'purple'])
Voir l'évènement
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
