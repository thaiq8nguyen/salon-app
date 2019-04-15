<!doctype html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        <style>@yield('style')</style>
    </head>
    <body>
        <div id="container" style="display: flex; justify-content: center;">
            @yield('content')
        </div>
    </body>
</html>

