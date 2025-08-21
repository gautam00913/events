<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="Gautier DJOSSOU <gautierdjossou@gmail.com>">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="images/jpeg" href="{{ asset('images/e-event-icon.jpeg') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="font-sans text-white bg-purple-900 antialiased">
            {{ $slot }}
        </div>
        <x-footer></x-footer>

        <script>
            let togglePassword = document.getElementById('togglePassword');
            let togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
            if(togglePassword){
                togglePassword.addEventListener('click', function(){
                    let password = document.getElementById('password');
                    if(password.getAttribute('type') == "password"){
                        password.setAttribute('type', 'text');
                        document.getElementById('eye-slash').classList.remove('hidden');
                        document.getElementById('eye-open').classList.add('hidden');
                    }else{
                        password.setAttribute('type', 'password');
                        document.getElementById('eye-open').classList.remove('hidden');
                        document.getElementById('eye-slash').classList.add('hidden');
                    }
                })
            }
            if(togglePasswordConfirmation){
                togglePasswordConfirmation.addEventListener('click', function(){
                    let password_confirmation = document.getElementById('password_confirmation');
                    if(password_confirmation.getAttribute('type') == "password"){
                        password_confirmation.setAttribute('type', 'text');
                        document.getElementById('confirmation-eye-slash').classList.remove('hidden');
                        document.getElementById('confirmation-eye-open').classList.add('hidden');
                    }else{
                        password_confirmation.setAttribute('type', 'password');
                        document.getElementById('confirmation-eye-open').classList.remove('hidden');
                        document.getElementById('confirmation-eye-slash').classList.add('hidden');
                    }
                })
            }
        </script>
    </body>
</html>
