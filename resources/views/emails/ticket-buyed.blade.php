@component('mail::message')
## Bonjour cher / chère {{ $event->user->name }}

Vous venez d'avoir un nouveau participant(**{{ $buyer->name }}**) pour votre évènement **{{ $event->title }}**.

*Détail de la transaction :*

@component('mail::table')
    
|# | Type de Billet | Prix Unitaire | Nombre de place | Total |
|--| :------------: |---------------|:---------------:| -----:|
@foreach ($tickets as $key => $ticket )
|{{ $key +1 }}| {{ $ticket['ticket_name'] }}      | {{ number_format($ticket['ticket_price'], 2, '.', ' '). ' '. config('app.devise') }}      | {{ $ticket['number_place'] }}      | {{ number_format($ticket['total_amount'], 2, '.', ' '). ' '. config('app.devise') }} |
@endforeach
@endcomponent
@component('mail::table')
| **Montant Total :**| {{ number_format($total_amount, 2, '.', ' '). ' '. config('app.devise') }}|
|--| :------------: |---------------|:---------------:| -----:|

@endcomponent

Accédez à votre tableau de bord pour connaitre le nombre total de participants déjà enregistré pour ce évènement.


@component('mail::button', ['url' => route('events.created'), 'color' => 'purple'])
Tableau de bord
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
