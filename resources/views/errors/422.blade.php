<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Erro 422</h2>
    </x-slot>

    <div class="card">
        <h1 class="section-title">Os dados fornecidos são inválidos.</h1>

        @if ($errors->any())
            <ul class="field-error">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>


