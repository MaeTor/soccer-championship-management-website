<!doctype html>
    <html>
    <head>
        <title>@yield('title')</title>
    </head>
    <body>
    <div class="border-b shadow-sm p-3 md:px-4 mb-3">
        <div>
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
