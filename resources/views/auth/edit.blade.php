<div>
    <form method="POST" action="{{ route('update', $user) }}" id="editUserForm" enctype="multipart/form-data">
        @method('PUT')
        <!-- Name -->
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <x-label for="name" :value="__('Nom et Prénom')" />
    
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?? $user->name" required autofocus />
            </div>
    
            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Adresse mail')" />
    
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" readonly />
            </div>
            <div>
                <x-label for="phone" :value="__('Numéro de Téléphone')" />
    
                <x-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="$user->phone" />
            </div>
            <div>
                <x-label for="image" :value="__('Avatar')" />
    
                <x-input id="image" class="block mt-1 w-full" type="file" name="image" :value="$user->image" />
            </div>
    
            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Nouveau Mot de passe')" />
    
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                :value="old('password') "
                                 autocomplete="new-password" />
            </div>
    
            <!-- Confirm Password -->
            <div>
                <x-label for="password_confirmation" :value="__('Confirmez le mot de passe')" />
    
                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"  />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button >
                {{ __('Sauvegarder') }}
            </x-button>
        </div>
    </form>
</div>

