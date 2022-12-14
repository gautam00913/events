<x-app-layout>
    <x-slot name="header">
        <h2 class="peer font-semibold text-xl text-white hover:text-yellow-500 leading-tight">
            Créer votre évènement
        </h2>
        <p class="w-1/2 border border-yellow-300 peer-hover:w-full"></p>
    </x-slot>
    <section class="container mx-auto pt-4 pb-10">
        <div class="bg-white rounded-lg px-3 md:px-10 py-10 w-4/5 md:w-1/2 mx-auto">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <form action="{{ route('events.store') }}" method="POST">
                @csrf
                    <div class="my-3">
                        <x-label  for="title" value="Titre de l'évènement" />
                        <x-input id="title" name="title" :value="old('title')" class="w-full" type="text" />
                    </div>
                    <div class="my-3">
                        <x-label  for="content" value="Description" />
                        <textarea id="content" name="content" :value="old('content')" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" > </textarea>
                    </div>
                    <div class="my-3">
                        <x-label  for="premium" value="Premium ?" />
                        <x-input id="premium" name="premium" value="1" type="checkbox" @if(old('premium')) checked @endif />
                    </div>
                    <div class="my-3">
                        <x-label  for="starts_at" value="Date de début" />
                        <x-input id="starts_at" name="starts_at" :value="old('starts_at')" class="w-full" type="datetime-local"/>
                    </div>
                    <div class="my-3">
                        <x-label  for="ends_at" value="Date de fin" />
                        <x-input id="ends_at" name="ends_at" :value="old('ends_at')" class="w-full" type="datetime-local" />
                    </div>
                    <div class="my-3">
                        <x-label  for="tags" value="Mots clés séparé par des virgules" />
                        <x-input id="tags" name="tags" :value="old('tags')" class="w-full" type="text" />
                    </div>
                    <div class="mt-5 flex justify-center">
                        <x-button>Créer l'évènement</x-button>
                    </div>
            </form>
        </div>
    </section>
</x-app-layout>