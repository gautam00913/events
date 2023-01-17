<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-purple-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="text-white">
                <div class=" max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 inline-block">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
        <script>
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
         
            $(document).ready(function(){
                        $(document).on('click', '.addTicketBtn', function(){
                            $('#addTicketModal').removeClass('hidden');
                            let id = $(this).data('id');
                            $('#select_option').val(id)
                            
                        });
                $('#AddTicket').click(function(){
                    let name = $('#add_ticket_name').val();
                    let id = $('#select_option').val()
                    if (name != '') {
                        $.post("{{ route('tickets.store') }}", {name : name}, function(data){
                            if (data.exist === 0) {
                                let option = '<option value="'+ data.ticket.id +'">'+ data.ticket.name +'</option>'
                                $('.tickets_option').append(option)
                            }
                            if (id) {
                                $('#'+ id).val(data.ticket.id)
                            }
                            $('#addTicketModal').addClass('hidden')

                        })
                    } else {
                        $('.error_ticket').text("Veillez remplir le nom du billet")
                    }
                });

                $('#ticket_number').on('input',()=>{
                    const tickets = document.querySelectorAll('fieldset')
                    const select = document.querySelector('#ticket_name_1')
                    let ticket_number = $('#ticket_number').val()
                    const reference = document.querySelector('.btn_create'),
                    form = document.getElementById('addEventForm')

                    if (tickets.length > ticket_number) {
                        if (ticket_number > 1) {
                            for(let i=tickets.length; i>ticket_number; i--){
                                tickets[i-1].remove()
                            }
                        } else {
                            for(let i=tickets.length; i>1; i--){
                                tickets[i-1].remove()
                            }
                        }
                    } else {
                       if (ticket_number > 5) {
                        ticket_number = 5
                        $('#ticket_number').val(5)
                       } 
                        for(let i=tickets.length+1; i<=ticket_number; i++){
                            const fieldset = document.createElement('fieldset')
                          fieldset.className = 'border px-4 py-2'
                          $.get("{{ route('tickets.create') }}", {id: ticket_number}, response => {
                              fieldset.innerHTML = response
                              form.insertBefore(fieldset, reference)
                          })

                        }
                    }
                })
            });
        </script>
    </body>
</html>
