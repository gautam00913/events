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
               <div class="grid md:grid-cols-3 md:gap-10 gap-5">
                    @foreach ($events as $event)
                       <x-dash-event :event="$event"></x-dash-event> 
                    @endforeach
                   
               </div>
                <div class="mt-1 text-white">
                    {{ $events->links() }}
                </div>
            @else
                <div class="justify-center shadow-lg h-64 flex items-center flex-col bg-white">
                    <p class="text-4xl animate-bounce">
                        📆
                    </p>
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
