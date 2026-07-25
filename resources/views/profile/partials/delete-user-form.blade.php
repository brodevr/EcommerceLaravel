<section class="space-y-6">
    <header>
        <h2 class="text-base font-semibold text-red-600">Eliminar cuenta</h2>
        <p class="mt-1 text-sm text-slate-500">
            Una vez eliminada tu cuenta, todos tus datos serán borrados permanentemente.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Eliminar cuenta</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-slate-800">¿Seguro que querés eliminar tu cuenta?</h2>
            <p class="mt-2 text-sm text-slate-500">
                Esta acción es irreversible. Ingresá tu contraseña para confirmar.
            </p>

            <div class="mt-5">
                <x-input-label for="password" value="Contraseña" class="sr-only" />
                <x-text-input id="password" name="password" type="password"
                              class="mt-1 block w-3/4" placeholder="Contraseña" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
                <x-danger-button>Eliminar cuenta</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
