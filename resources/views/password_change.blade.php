@extends('base')
@section('title')
Créer un mot de passe
@endsection
@section('content')
<form @class(['space-y-4']) method="POST" action="{{ route('update.password') }}">
    @csrf
    @if ($errors->any())
    <div class="alert-warning">
        Erreur dans la modification du mot de passe.
    </div>
    @endif
    <div @class(['flex', 'flex-row' ])>

        <input type="text" id="old_password" class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-900
                    focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            name="old_password" aria-describedby="old_password_feedback" minlength="3" maxlength="20" required
            placeholder="Ancien mot de passe" @error("old_password") class="is-invalid" @enderror>
        @error("old_password")
        <div id="old_password_feedback" class="invalid-feedback">{{ $message }} </div>
        @enderror

        <input type="text" id="new_password" class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-900
                    focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            name="new_password" aria-describedby="new_password_feedback" minlength="3" maxlength="20" required
            placeholder="Nouveau Mot de passe" @error("new_password") class="is-invalid" @enderror>
        @error("new_password")
        <div id="new_password_feedback" class="invalid-feedback">{{ $message }} </div>
        @enderror

        <input type="text" id="repeat_new_password" class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-900
                    focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            name="repeat_new_password" aria-describedby="repeat_new_password_feedback" minlength="3" maxlength="20"
            required placeholder="Répéter le Nouveau Mot de passe" @error("repeat_new_password") class="is-invalid"
            @enderror>
        @error("repeat_new_password")
        <div id="repeat_new_password_feedback" class="invalid-feedback">{{ $message }} </div>
        @enderror

    </div>

    <button type="submit" class="btn-primary">
        Soumettre
    </button>
</form>
@endsection