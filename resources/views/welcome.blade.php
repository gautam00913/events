<x-app-layout>
    <x-slot:title>Plateforme de billeterie d'évènement en ligne.</x-slot:title>
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            {{ __('Evènements en cours avant'). ' '. now()->addMonth(3)->translatedFormat('M Y') }}
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full transition ease-in-out delay-700"></p>
    </x-slot>

    <section>
        <div class="px-5 md:px-10 lg:px-20 py-10">
            @if ($events->count())
                <div class="grid md:grid-cols-2 lg:grid-cols-3 md:gap-10 gap-5">
                    @foreach ( $events as $event )
                        <x-event :event="$event" />
                    @endforeach 
                </div>
                <div class="mt-4 text-white">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center bg-white pb-10 rounded-lg">
                    <img src="{{ asset('images/events.png') }}" class="w-full rounded-lg h-96 object-cover" />
                   
                    <p class="my-4 text-yellow-600">
                        Pas d'évènement disponible avant les trois prochains mois.
                    </p>
                    <p>
                        <x-link :href="route('events.index')">Voir tous les évènements</x-link>
                    </p>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
