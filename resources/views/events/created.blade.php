<x-app-layout>
    <x-slot name="title">Liste des évènements créés par {{ auth()->user()->name }}</x-slot>
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            Liste des évènements créés
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
    </x-slot>
    <section>
        <div class="px-5 md:px-20 py-5">
            @if ($events->count())
                <div class="mb-5 text-end">
                    <x-link :href="route('events.create')" class="justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="group-hover:text-white w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>
                        Ajouter un évènement
                    </x-link>
                </div>
               <div class="grid md:grid-cols-2 lg:grid-cols-3 md:gap-10 gap-5">
                    @foreach ($events as $event)
                       <x-dash-event :event="$event"></x-dash-event> 
                    @endforeach
                   
               </div>
                <div class="mt-1 text-white">
                    {{ $events->links() }}
                </div>
            @else
                <div class="justify-center shadow-lg flex items-center flex-col bg-white rounded-lg overflow-hidden">
                    <img src="{{ asset('images/events.png') }}" class="w-full rounded-t-lg h-52 object-cover" />
                    <p>
                        Pas d'évènement ajouté
                    </p>
                        <p class="mt-4">
                            <x-link href="{{ route('events.create') }}">Ajoutez votre premier évènement</x-link>
                        </p>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
