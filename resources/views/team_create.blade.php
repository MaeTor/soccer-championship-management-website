@extends('base')
    @section('title')
        Création d'une équipe
    @endsection
    @section('content')
        <form class="space-y-4" method="POST">
        <div class="flex flex-col">
            <label for="team_name" class="text-sm font-medium text-gray-700 mb-1">
            Nom de l'équipe
            </label>
            <input
            type="text"
            id="team_name"
            class="border border-gray-300 rounded-md px-3 py-2 text-gray-900
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
            name="team_name"
            >
        </div>

        <button
            type="submit"
            class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium
                rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
        >
            Soumettre
        </button>
        </form>
    @endsection