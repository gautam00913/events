<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="author" content="Gautier DJOSSOU <gautierdjossou@gmail.com>">
        <title>{{ config('app.name', 'E-events') }}@isset($title) | {{ $title }} @endisset</title>

        <link rel="icon" type="images/jpeg" href="{{ asset('images/e-event-icon.jpeg') }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- <link rel="stylesheet" href="{{ asset('build/assets/app.29633b93.css') }}"> --}}
        <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
        @yield('int-tel-phone')
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
    <div class="relative w-full h-full max-w-2xl md:max-w-4xl">
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
<div id="confirmationModal" class="hidden w-full fixed min-h-screen top-0 left-0 z-50 bg-transparent" style="transition: opacity .15s linear; outline: 0;">
    <div class="relative top-5 w-11/12 md:w-1/2 mx-auto bg-white rounded-md px-3 py-2 shadow-2xl h-3/4 bg-clip-padding border border-gray-400 mb-3">
       
        <div id="confirmMessage">
           
        </div>
    </div>
</div>
 
          
        <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
        {{-- <script src="{{ asset('build/assets/app.61cdcf6c.js') }}"></script> --}}

        <script>
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
         
            $(document).ready(function(){
                let phoneInput = null;
                const modal = new Modal(document.getElementById('modalEl'));

                $(document).on('click', '.closeModal', function(){
                        modal.hide();                            
                });
                $(document).on('click', '.addTicketBtn', function(){
                    $('#addTicketModal').removeClass('hidden');
                    let id = $(this).data('id');
                    $('#select_option').val(id)
                    
                });
                $(document).on('click', '.shareEvent', function(e){
                    e.preventDefault();
                    let url = "{{ route('events.index') }}";
                    let slug = $(this).data('slug');
                    let event = $(this).data('event');
                    url += `?event=${slug}`;
                    let html = '<p class="italic font-semibold">Partagez par : </p>'
                     html += `<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5">
                        <x-button class="social_share m-3 justify-center" data-type="fb" data-url="${url}">
                            Facebook
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="twitter" data-url="${url}">
                            Twitter
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="gplus" data-url="${url}">
                            Google+
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="googlebookmarks" data-url="${url}">
                            Google Bookmarks
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="livejournal" data-url="${url}">
                            LiveJournal
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="tumblr" data-url="${url}">
                            Tumblr
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="pinterest" data-url="${url}">
                            Pinterest
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="reddit" data-url="${url}">
                            Reddit
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="mailru" data-url="${url}">
                            Mail.ru
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="weibo" data-url="${url}">
                            Weibo
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="skype" data-url="${url}">
                            Skype
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="telegram" data-url="${url}">
                            Telegram
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="whatsapp" data-url="${url}">
                            Whatsapp
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="viber" data-url="${url}">
                            Viber
                        </x-button>
                        <x-button class="social_share m-3 justify-center" data-type="email" data-url="${url}">
                            Email
                        </x-button>
                        </div>`;
                        $('#modalTitle').html("Partagez l'évènement <span class='font-semibold text-purple-700'>"+ event + '</span>')
                    $('#modalContent').html(html)
                    modal.show();

                    
                });
                $(document).on('click', '#AddTicket', function(){
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

                $(document).on('input', '#ticket_number',()=>{
                    const tickets = document.querySelectorAll('fieldset')
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
                    let info = $(this).parent().siblings('.event_tickets').html()
                    let flyers = e.target.parentElement.parentElement.parentElement.querySelector('img.flyers').src
                    const event = e.target.parentElement.parentElement.parentElement.querySelector('h2.event_title')
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
                    const ticket_ids = document.querySelectorAll('form .ticket_ids:checked')
                    const event_name = document.querySelector('form input[name="event_name"]').value
                    const event_id = document.querySelector('form input[name="event_id"]').value
                    const error = document.getElementById('error')
                    let price = 0, tickets_id = [], tickets_place = []
                    const tickets = Array.from(ticket_ids);

                    if (tickets.length === 0) {
                        error.classList.remove('hidden')
                        error.textContent = "Veillez cocher au moins une case";
                        setTimeout(() => {
                            error.classList.add('hidden')
                            error.textContent =''
                        }, 3000);
                    } else {
                        let isValid = true
                        tickets.forEach(function(ticket, index){
                            const id = ticket.dataset.id;
                            const qty = Number(document.querySelector(`form #number_place_ticket_${id}`).value)
                            if (qty >= 1) {
                                const amount = Number(document.querySelector(`form #ticket_price_${id}`).value)
                                price += (amount * qty)
                                tickets_id.push(ticket.value)
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

                //edit user info
                $('#editUser').on('click', () => {
                    $.get("{{ route('edit') }}", response => {
                        $('#modalTitle').html("Vos informations personnelles")
                        $('#modalContent').html(response)
                        modal.show(); 
                        phoneInput = window.intlTelInput(document.querySelector("#phone"), {
                            initialCountry: "auto",
                            geoIpLookup: function(success, failure) {
                                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                                var countryCode = (resp && resp.country) ? resp.country : "us";
                                success(countryCode);
                                });
                            },
                            utilsScript:
                                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                        });  
                    })
                })
                //events participations History
                $('#participationsHistory').on('click', () => {
                    $.get("{{ route('events.participations') }}", response => {
                        $('#modalTitle').html("Vos Billets d'évènements achetés")
                        $('#modalContent').html(response)
                        modal.show(); 
                    })
                })

                $(document).on('submit', '#editUserForm', function(e) {
                    e.preventDefault();
                    const data = new FormData(this)
                    data.set('phone', phoneInput.getNumber())
                    axios.post(this.action, data)
                        .then(response => {
                            if (response.data.user) {
                                window.location = ""
                            }
                        })
                        .catch(error => {
                            const errors = Object.entries(error.response.data.errors)
                            errors.forEach((element) => {
                                [key, message] = element
                                document.getElementById(key).classList.add('border-red-600')
                                document.getElementById(key).insertAdjacentHTML('afterend', `
                                <p class="text-red-600 italic">${message[0]}</p>
                                `)
                            })
                    })
               
                });
                //show event participants
                $(document).on('click', '.eventParticipants', function(){
                    const event = $(this).data('event');
                    $.get($(this).data('url'), response => {
                        $('#modalTitle').html(`Liste des participants de l'évènement <span class='text-purple-800'>${event}</span>`)
                        $('#modalContent').html(response)
                        modal.show(); 
                    })
                })
                //edit event
                $(document).on('click', '.editEvent', function(){
                    $.get($(this).data('url'), response => {
                        $('#modalTitle').html("Modification de l'évènement")
                        $('#modalContent').html(response)
                        modal.show(); 
                    })
                })
                //Update event
                $(document).on('click', '#updateEvent', function(e){
                    e.preventDefault()
                    const form = e.target.parentElement.parentElement
                    const data = new FormData(form)
                    axios.post(form.action, data)
                    .then( response => {
                        if (response.data.updated) {
                                window.location = ""
                            }
                    })
                    .catch(error => {
                        const errors = Object.entries(error.response.data.errors)
                        console.log(errors);
                            errors.forEach((element) => {
                                [key, message] = element
                                document.getElementById(key).classList.add('border-red-600')
                                document.getElementById(key).insertAdjacentHTML('afterend', `
                                <p class="text-red-600 italic">${message[0]}</p>
                                `)
                            })
                    })
                });
                //delete event
                $(document).on('click', '.deleteEvent', function(){
                    const form = `
                        <form action="${$(this).data('url')}" method="POST">
                            @csrf
                            @method('DELETE')
                            <p>Souhaitez-vous vraiment supprimer l'évènement <span class="font-bold">${$(this).data('name')}</span> ?</p>
                            <div class="flex items-center justify-between my-3">
                                <x-button type="button" id="cancelConfim">Annuler</x-button>
                                <x-button type="submit" class="bg-red-600">Supprimer</x-button>
                            </div>
                        </form>
                    `
                   $('#confirmMessage').html(form)
                   $('#confirmationModal').removeClass('hidden')
                })
        
                //close confirmation modal
                $(document).on('click', '#cancelConfim', function(e){
                    e.preventDefault()
                    $('#confirmMessage').html('')
                   $('#confirmationModal').addClass('hidden')
                })

                //transactions history
                $(document).on('click', '#transactionsHistory', function(e) {
                    e.preventDefault();
                    axios.get("{{ route('transactions.history') }}")
                    .then(response => {
                        $('#modalTitle').html("Historique des virements")
                        $('#modalContent').html(response.data)
                        modal.show(); 
                    })
                    .catch(error => console.log(error))
                });
                //init payment request
                $(document).on('click', '#claimAmount', function(e) {
                    e.preventDefault();
                    axios.get("{{ route('transactions.create') }}")
                    .then(response => {
                        $('#modalTitle').html("Demande de virement d'argent vers votre compte")
                        $('#modalContent').html(response.data)
                        modal.show(); 
                    })
                    .catch(error => console.log(error))
                });
                //insert payment request
                $(document).on('submit', '#insertTransactionForm', function(e) {
                        e.preventDefault();
                        const data = new FormData(this)
                        axios.post(this.action, data)
                            .then(response => {
                                if (response.data.transaction) {
                                    window.location = ""
                                }
                            })
                            .catch(error => {
                                const errors = Object.entries(error.response.data.errors)
                                errors.forEach((element) => {
                                    [key, message] = element
                                    document.getElementById(key).classList.add('border-red-600')
                                    document.getElementById(key).insertAdjacentHTML('afterend', `
                                    <p class="text-red-600 italic">${message[0]}</p>
                                    `)
                                })
                        })
                   
                });
                //transaction validation
                $('.validateTransaction').on('click', function(e) {
                        e.preventDefault();
                        const url = $(this).data('url');
                        const id = $(this).data('id');
                        axios.get(url)
                            .then(response => {
                                $('#modalTitle').html("Approbation de la transaction n° "+ id)
                                $('#modalContent').html(response.data)
                                modal.show();
                            })
                            .catch(error => {
                                console.log(error);
                                })
                        })
                   
                });
            });

        </script>
    </body>
</html>
