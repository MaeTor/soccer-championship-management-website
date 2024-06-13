<!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')
        <title>@yield('title')</title>
    </head>
    <body>
    <div class="border-b shadow-sm p-3 md:px-4 mb-3">
        <div class="container mx-auto flex flex-col md:flex-row items-center">
            <h5>@yield('title')</h5>
            <nav>
                <a href="/">Classement</a>
            </nav>
            <a href="/login">Connexion</a>
        </div>
    </div>
    <div>
        @yield('content')
    </div>
    </body>
</html>
