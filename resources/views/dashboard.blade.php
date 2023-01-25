<x-app-layout>
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            Tableau de Bord
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pb-10">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid md:grid-cols-3 gap-4">
                        <x-card class="flex flex-col justify-between">
                            <div class="flex space-x-3">
                                <div class="h-20 w-20 rounded-full p-2 border border-purple-600 group-hover:border-yellow-200">
                                    <img src="{{ asset('/images/avatar.png') }}" alt="default avatar" />
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
                            <x-button type="button" class="w-full justify-center" id="eventsHistory">Historique</x-button>
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
            </div>
        </div>
    </div>
</x-app-layout>
