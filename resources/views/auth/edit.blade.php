<div>
    <form method="POST" action="{{ route('update', $user) }}" id="editUserForm">
        @method('PUT')
        <!-- Name -->
        <div>
            <x-label for="name" :value="__('Nom et Prénom')" />

            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?? $user->name" required autofocus />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-label for="email" :value="__('Adresse mail')" />

            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" readonly />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-label for="password" :value="__('Nouveau Mot de passe')" />

            <x-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            :value="old('password') "
                             autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-label for="password_confirmation" :value="__('Confirmez le mot de passe')" />

            <x-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"  />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button >
                {{ __('Sauvegarder') }}
            </x-button>
        </div>
    </form>
</div>
