<x-app-layout>
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            Liste des évènements
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
    </x-slot>
    <section>
        <div class="px-5 md:px-20 py-10">
            @if ($events->count())
                <div class="grid md:grid-cols-3 md:gap-10 gap-5">
                    @foreach ( $events as $event )
                        <x-event :event="$event" />
                    @endforeach 
                </div>
            @else
                <div class="justify-center shadow-lg h-64 flex items-center flex-col">
                    <p>

                        Pas  d'évènement disponible
                    </p>
                    <p class="mt-4">
                        <x-link href="{{ route('events.index') }}">Afficher tous les évènements</x-link>
                    </p>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
