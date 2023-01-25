<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}@isset($title) | {{ $title }} @endisset</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
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
            <x-toast :message="session()->has('toast') ? session()->get('toast')['message'] : ''"
                :type="session()->has('toast') ? session()->get('toast')['type'] : 'success'">
            </x-toast>
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        

   <!-- Main modal -->
   <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modalTitle">
                  ...
                </h3>
                <button type="button" class="closeModal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>

            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6" id="modalContent">
               
            </div>
            <!-- Modal footer -->
            <div id="modalFooter" class="invisible flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <x-button data-modal-hide="myModal" type="button">I accept</x-button>
                <button data-modal-hide="myModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
            </div>
        </div>
    </div>
</div>
 
          
        <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
        <script>
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
         
            $(document).ready(function(){
                const modal = new Modal(document.getElementById('modalEl'));

                        $(document).on('click', '.closeModal', function(){
                                modal.hide();                            
                        });
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

                //buy ticket
                $('.buyTicket').click(function(e){
                    let info = $(this).siblings('.event_tickets').html()
                    let flyers = e.target.parentElement.parentElement.querySelector('img.flyers').src
                    const event = e.target.parentElement.parentElement.querySelector('h2.event_title')
                    const div = document.createElement('div')
                    const img = document.createElement('img')
                    div.className="grid md:grid-cols-2 gap-4 md:gap-6 px-3"
                    img.className="object-center object-cover w-full h-full rounded-lg border border-white"
                    img.src = flyers
                    div.appendChild(img)
                    div.innerHTML += `
                        <form>
                            <div id="error" class="hidden text-red-500 italic mb-3 bg-red-200 px-2 py-1 rounded"></div>
                            <input type="hidden" name="event_name" value="${event.textContent}" />
                            <input type="hidden" name="event_id" value="${event.id}" />
                            ${info}
                            <x-button class="w-full my-3 justify-center" type="button" id="buyEventTicket">Acheter</x-button>
                        </form>
                    `
                    $('#modalTitle').html("Achat de billets pour l'évènement <span class='font-semibold text-purple-700'>"+ event.textContent + '</span>')
                    $('#modalContent').html(div)
                    modal.show();
                })
                $(document).on('click', '#buyEventTicket', function(e){
                    e.preventDefault()
                    const ticket_prices = document.querySelectorAll('form .ticket_prices')
                    const ticket_numbers = document.querySelectorAll('form input[name="number_places\[\]"]')
                    const tickets = document.querySelectorAll('form input[name="tickets\[\]"]:checked')
                    const event_name = document.querySelector('form input[name="event_name"]').value
                    const event_id = document.querySelector('form input[name="event_id"]').value
                    const error = document.getElementById('error')
                    let price = 0, tickets_id = [], tickets_place = []
                    if (tickets.length === 0) {
                        error.classList.remove('hidden')
                        error.textContent = "Veillez cocher au moins une case";
                        setTimeout(() => {
                            error.classList.add('hidden')
                            error.textContent =''
                        }, 3000);
                    } else {
                        let isValid = true
                        tickets.forEach(function(ticket_id, index){
                            const qty = Number(ticket_numbers[index].value)
                            if (qty >= 1) {
                                const amount = Number(ticket_prices[index].value)
                                price += (amount * qty)
                                tickets_id.push(ticket_id.value)
                                tickets_place.push(qty)  
                            } else {
                                isValid = false;
                                return;
                            }
                            
                        })
                        if (!isValid) {
                            error.classList.remove('hidden')
                            error.textContent = "Veillez renseigner le nombre de place pour chaque billet";
                            setTimeout(() => {
                                error.classList.add('hidden')
                                error.textContent =''
                            }, 3000);
                        } else {
                            let widget =  FedaPay.init({
                                public_key: 'pk_sandbox_GVYrmawmN6UDU4Y0YVCLTeQi',
                                transaction:{
                                    amount: price,
                                    description: "Achat de billets pour l'évènement "+ event_name
                                },
                                onComplete: function(data){
                                    if(data.reason === "CHECKOUT COMPLETE" && data.transaction.status === 'approved'){
                                        window.location = "{{ route('tickets.buy') }}?event_id="+ event_id +"&payment_id="+ data.transaction.id +"&tickets_id="+ JSON.stringify(tickets_id) + "&tickets_place=" + JSON.stringify(tickets_place)
                                    }else{
                                        console.log(data);
                                    }
                                }
                            });
                            widget.open();
                        }
                    }
                })
              //toast
                $('#toast').delay(5000).hide('slow')
                $('#closeToast').on('click', () => $('#toast').hide())
            });
        </script>
    </body>
</html>
