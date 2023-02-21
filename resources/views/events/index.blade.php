<x-app-layout>
    <x-slot name="title">Plateforme évènementielle regroupant les meilleurs évènements et les meilleurs artistes, organisateurs d'évènements</x-slot>
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            Liste des évènements disponibles sur la plateforme.
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
    </x-slot>
    <section class="container">
        <h2 class="text-yellow-300 px-4 sm:px-6 lg:px-8 font-semibold text-lg">
            Profitez de l'ensemble de nos meilleurs évènements. Participez aux évènements 
            de vos artistes préférés en achetant leur billet en ligne sans vous déplacer de votre maison.
            C'est chic 😍.
        </h2>
        <div class="px-5 md:px-20 py-10">
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
                <div class="justify-center shadow-lg h-64 flex items-center flex-col bg-white">
                    <p class="text-4xl animate-bounce">
                        📆
                    </p>
                    <p>
                        Pas  d'évènement disponible
                    </p>
                    @if (Request::query('search'))
                        <p class="mt-4">
                            <x-link href="{{ route('events.index') }}">Afficher tous les évènements</x-link>
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
