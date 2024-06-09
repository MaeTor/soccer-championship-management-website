<!doctype html>
    <html>
    <head>
        <title>@yield('title')</title>
    </head>
    <body>
    <div>
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
