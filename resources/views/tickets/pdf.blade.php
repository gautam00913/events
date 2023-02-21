<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Billet Electronique</title>
    <style>
        #bg {
          background-image: url("{{ asset('images/ticket_default.png') }}");
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: 100% 100%;
          border: 1px solid purple;
          padding: 1rem;
          border-radius: 0.6rem;
          height: 100vh;
          opacity: 0.4;
        }
        body{
            border: 0;
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-size: 0.7rem;
        }
        #title{
            color: purple;
            text-transform: uppercase;
            padding: 0;
            margin: 0;
            font-size: 1.1rem;
        }
        
        </style> 
</head>
<body>
    <div id="bg">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td>
                        <div style="display: inline-block; margin-bottom: 1.3rem;">
                            <h1 id="title">Billet Electronique</h1>
                            <p style="border: 1px solid rgb(206, 187, 18); width: 50%;  padding: 0;margin: 0;"></p>
                        </div>
                    </td>
                    <td>
                        <strong>TK-{{ $name }}</strong> <br>
                        <small style="font-size: 0.5rem; font-style: italic;">{{ $reserve_at->format('d/m/Y H:i') }}</small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p><b>Nom de l'évènement : </b> {{ $event->title }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p><b>Organisateur : </b> {{ $event->user->name }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
      
        <table width="100%" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td>
                        <p><b>Date de début : </b> {{ $event->starts_at->format('d/m/Y H\h i\m\i\n') }}</p>
                        @if ($event->ends_at)
                            <p><b>Date de fin : </b> {{ $event->ends_at->format('d/m/Y H\h i\m\i\n') }}</p>
                        @endif
                        <p><b>Type de billet : </b> {{ $ticket->name }}</p>
                        <p><b>Prix unitaire : </b> {{ number_format($ticket->pivot->price, 2, '.', ' '). ' '. config('app.devise') }}</p>
                        <p><b>Nombre de places : </b> {{ $place_reserved }}</p>
                    </td>
                    <td >
                        <div align="right">
                            <img style="border: 1px solid white; padding: 2px;" width="120" height="90" src="{{ asset($qrcode) }}" alt="qr code">
                        </div>
                        <p style="text-align: center; text-decoration: underline;"><b>{{ $buyer_name }}</b></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
</body>
</html>