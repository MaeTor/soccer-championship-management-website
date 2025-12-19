<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>@yield('title')</title>
</head>

<body>
    <div class="border-b shadow-xs p-3 md:px-4 mb-3">
        <div class="container mx-auto flex flex-col md:flex-row items-center">
            <h5 class="text-lg font-normal mr-auto">@yield('title')</h5>
            <nav class="my-2 md:my-0 md:mr-3">
                <a href="/" class="px-2 text-gray-800 hover:text-gray-600">Classement</a>
            </nav>
            @if (session()->has('user'))
            <form method="POST" action="{{route('logout')}}">
                <div class="inline-flex flex-col sm:flex-row rounded-md shadow-sm">
                    <a class="btn-outline-danger" href="{{route('teams.create')}}">Créer une
                        équipe</a>
                    <a class="btn-outline-danger" href="{{route('matches.create')}}">Ajouter
                        un match</a>
                    <span class="btn-primary text-gray-400 cursor-not-allowed select-none">{{ session()->get('user')['email'] }}
                    </span>
                    <button type="submit" class="border border-blue-500 text-blue-500 px-4 py-2 rounded-sm hover:bg-blue-500 hover:text-white transition-colors">Déconnexion</a>
                </div>
            </form>
            @else
            <a class="border border-blue-500 text-blue-500 px-4 py-2 rounded-sm hover:bg-blue-500 hover:text-white transition-colors" href="/login">Connexion</a>
            @endif
        </div>
    </div>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>