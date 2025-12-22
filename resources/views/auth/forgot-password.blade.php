<x-guest-layout>
    <p class="section-text">
        Esqueceu sua senha? Sem problemas. Informe seu email e enviaremos um link para redefinir sua senha.
    </p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="row-end">
            <x-primary-button>Enviar link de redefinição</x-primary-button>
        </div>
    </form>
</x-guest-layout>
