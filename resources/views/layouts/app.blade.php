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
                $('.addTicketBtn').click( function(){
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
                          fieldset.innerHTML = `
                                <legend>Billet n° ${i}</legend>
                                <div class="tickets">
                                    <div class="my-3 flex items-center">
                                        <x-label  for="ticket_name_${i}" class="mr-3">
                                            Nom du billet <span class='text-red-600'>*</span>
                                        </x-label>
                                       <div class="flex-1 flex">
                                        <x-select id="ticket_name_${i}" name="ticket_name[]" class="flex-1 rounded-md rounded-r-none border-r-0 tickets_option" required>
                                            ${select.innerHTML}
                                        </x-select>
                                        <button data-id="ticket_name_${i}" type="button" class="text-black border rounded-l-none rounded-md border-gray-300 addTicketBtn">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                              </svg>
                                        </button>
                                       </div>
                                    </div>
                                    <div class="my-3">
                                        <x-label  for="ticket_price_${i}">
                                            Prix unitaire <span class='text-red-600'>*</span>
                                        </x-label>
                                        <x-input id="ticket_price_${i}" name="ticket_price[]" class="w-full" type="number" required min="0"/>
                                      
                                    </div>
                                    <div class="my-3">
                                        <x-label  for="ticket_place_${i}">
                                            Nombre de place réservé <span class='text-red-600'>*</span>
                                        </x-label>
                                        <x-input id="ticket_place_${i}" name="ticket_place[]" class="w-full" type="number" required min="0"/>
                                      
                                    </div>
                                </div>
                            `
                            form.insertBefore(fieldset, reference)
                        }
                    }
                })
            });
        </script>
    </body>
</html>
