<x-app-layout>
    <x-slot name="header">
        Liste des évènements
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
                <div class="text-center">
                    Pas d'évènement disponible
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
