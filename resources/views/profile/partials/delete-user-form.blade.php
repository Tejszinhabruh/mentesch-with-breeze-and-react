<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Fiók törlése') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('A fiókod törlését követően az összes hozzá tartozó adat véglegesen törlődik. A fiók törlése előtt kérjük, töltse le az összes olyan adatot vagy információt, amelyet meg szeretne őrizni.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Fiók törlése') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Biztos vagy benne hogy törölni akarod a fiókodat?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('A fiókod törlését követően az összes hozzá tartozó adat véglegesen törlődik. Kérjük, adja meg jelszavát a fiók végleges törlésének megerősítéséhez.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Jelszó') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Mégse') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Fiók törlése') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
