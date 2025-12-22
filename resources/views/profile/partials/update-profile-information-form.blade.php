<section>
    <header>
        <h2 class="section-title">
            Informações do Perfil
        </h2>
        <p class="section-text">
            Atualize as informações do perfil e o endereço de email da sua conta.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="stack">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="section-text">
                        Seu endereço de email não foi verificado.

                        <button form="send-verification" class="text-link">
                            Clique aqui para reenviar o email de verificação.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="note-success">
                            Um novo link de verificação foi enviado para o seu endereço de email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="row">
            <x-primary-button>Salvar</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="help">Salvo.</p>
            @endif
        </div>
    </form>
</section>