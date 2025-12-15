@extends('base')
@section('title')
Création d'une équipe
@endsection
@section('content')
<form @class(['space-y-4']) method="POST" action="{{route('teams.store')}}">
    @csrf
    @if ($errors->any())
    <div class="alert-warning">
        L'équipe n'a pas pu être ajoutée &#9785;
    </div>
    @endif
    <div @class(['flex', 'flex-col' ])>
        <label for="team_name" @class(['text-sm', 'font-medium' , 'text-gray-700' , 'mb-1' ])>
            Nom de l'équipe
        </label>
        <input value="{{ old('team_name') }}" type="text" id="team_name" class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-900
                    focus:outline-hidden focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            name="team_name" aria-describedby="team_name_feedback" minlength="3" maxlength="20" required 
            @error("team_name") class="is-invalid" @enderror>
    </div>
    @error("team_name")
    <div id="team_name_feedback" class="invalid-feedback">{{ $message }} </div>
    @enderror

    <button type="submit" class="btn-primary">
        Soumettre
    </button>
</form>
@endsection