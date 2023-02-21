<x-app-layout>
    @section('int-tel-phone')
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
    />    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    @endsection
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            Tableau de Bord
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
    </x-slot>
    <x-slot name="title">Tableau de Bord de {{ $user->name }}</x-slot>
   
  <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pb-10">
                <div class="mb-4 md:mb-6 p-6 bg-white border-b border-gray-200">
                    <div class="grid md:grid-cols-3 gap-4">
                        <x-card class="flex flex-col justify-between">
                            <div class="flex space-x-3">
                                <div class="h-20 w-20 rounded-full p-1 border border-purple-600 group-hover:border-yellow-200">
                                    @if ($user->image)
                                        <img src="{{ Storage::url($user->image) }}" alt="Avatar de {{ $user->name }}" class="w-full h-full rounded-full object-center" />
                                    @else
                                        <img src="{{ asset('images/avatar.png') }}" alt="default avatar" class="w-full h-full rounded-full object-center" />
                                    @endif
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold mb-2 group-hover:text-white">
                                        {{ $user->name }}
                                    </h2>
                                    <h2 class="text-yellow-500 italic group-hover:text-yellow-100">
                                        {{ $user->email }}
                                    </h2>
                                </div>
                            </div>
                            <x-button type="button" class="w-full justify-center" id="editUser">Modifier mes informations</x-button>
                        </x-card>
                        
                        <x-card class="flex flex-col justify-between">
                            <p class="flex justify-center mb-3 relative">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="group-hover:text-white w-12  h-12">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                                <a title="Ajouter un nouvel évènement" href="{{ route('events.create') }}" class="text-3xl w-8 h-8 flex items-center justify-center rounded-full border border-yellow-400 group-hover:text-white group-hover:border-white">+</a>
                            </p>
                            <p class="text-center group-hover:text-white mb-3">
                                Evènement(s) créé(s) <span class="text-yellow-500 group-hover:text-yellow-300 group-hover:font-bold">( {{ $user->events_count }} )</span>
                            </p>
                            <x-link :href="route('events.created')" class="w-full justify-center" id="eventsHistory">Historique</x-link>
                        </x-card>
                        <x-card class="flex flex-col justify-between">
                            <p class="text-center text-4xl mb-3">
                                    📆
                            </p>
                            <p class="text-center group-hover:text-white mb-3">
                                Billet(s) d'évènement  acheté(s) <span class="text-yellow-500 group-hover:text-yellow-300 group-hover:font-bold">( {{ $user->participations_count }} )</span>
                            </p>
                            <x-button type="button" class="w-full justify-center" id="participationsHistory">Historique</x-button>
                        </x-card>
                    </div>
                </div>

                <div class="px-6">
                    <div class="inline-block mb-3">
                        <h3 class="peer font-semibold text-lg text-purple-800 hover:text-yellow-500 leading-tight">
                            Porte Feuille
                        </h3>
                        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-4">
                        <x-card class="flex flex-col justify-between">
                            <p class="flex justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                </svg>
                            </p>
                            <p class="text-center group-hover:text-white mb-3">
                                Montant collecté sur vos évènements  créés <span class="text-yellow-500 group-hover:text-yellow-300 group-hover:font-bold">( {{ number_format($total_amount - $user->transactions_sum_refunded_amount, 2, '.', ' '). ' '. config('app.devise') }} )</span>
                            </p>
                            <x-button type="button" class="w-full justify-center" id="claimAmount">Demander un virement</x-button>
                        </x-card>
                        <x-card class="flex flex-col justify-between">
                            <p class="flex justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </p>
                            <p class="text-center group-hover:text-white mb-3">
                                Montant déjà reçu <span class="text-yellow-500 group-hover:text-yellow-300 group-hover:font-bold">( {{ number_format($user->transactions_sum_refunded_amount, 2, '.', ' '). ' '. config('app.devise') }} )</span>
                            </p>
                            <x-button type="button" class="w-full justify-center" id="participationsHistory">Historique</x-button>
                        </x-card>
                        <x-card class="flex flex-col justify-between">
                            <p class="flex justify-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>

                            </p>
                            <p class="text-center group-hover:text-white mb-3">
                                Vos dépenses pour billet(s) d'évènement  acheté(s) <span class="text-yellow-500 group-hover:text-yellow-300 group-hover:font-bold">( {{ number_format($user->participations_sum_event_usertotal_amount, 2, '.', ' '). ' '. config('app.devise') }} )</span>
                            </p>
                            <x-link :href="route('events.index')" class="w-full justify-center">Participer à des évènements</x-link>
                        </x-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
