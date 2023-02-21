@component('mail::message')
## Cher/ chère {{ $user->name }}

Merci pour votre inscription sur [**{{ config('app.name') }}**]({{ route('home') }}).

Vos informations de connection :
- **E-mail :** *{{ $user->email }}*
- **Mot de passe :** _{{ $password }}_

Accédez à notre plateforme à tout moment et :
- *participez à tous vos évènements préférés*
- *créez vos évènements et invités vos amis, fans à achecter vos billets sans se déplacer*
- *faites assez de revenus avec [__{{ config('app.name') }}__]({{ route('home') }}) et 
depensez moins d'effort dans la vente de vos billets.*

@component('mail::button', ['url' => route('login'), 'color' => 'purple'])
Connectez-vous maintenant
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
