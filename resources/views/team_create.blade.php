@extends('base')
@section('title')
Création d'une équipe
@endsection
@section('content')
<form @class(['space-y-4']) method="POST" action="{{route('teams.store')}}">
    @csrf
    @if ($errors->any())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 px-4 py-3 rounded-sm">
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
            @error("team_name") class="border border-red-500 rounded-md px-3 py-2 text-gray-900 focus:outline-hidden focus:ring-2 focus:ring-red-500 focus:border-red-500 transition" @enderror>
    </div>
    @error("team_name")
    <div id="team_name_feedback" class="class=text-sm text-red-600 mt-1">{{ $message }} </div>
    @enderror

    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium
                rounded-md shadow-xs hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-blue-500 transition">
        Soumettre
    </button>
</form>
@endsection