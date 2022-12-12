<x-app-layout>
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            {{ __('Evènements en cours avant'). ' '. now()->addMonth(3)->translatedFormat('M Y') }}
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
                <div class="mt-4 text-white">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center">
                    <p>
                        Pas d'évènement disponible avant les trois prochains mois.
                    </p>
                    <p>
                        <x-link>Voir tous les évènements</x-link>
                    </p>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
