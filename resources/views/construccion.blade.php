<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EN CONSTRUCCIÓN</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href='{{URL::asset('/css/generico.css')}}' type='text/css' rel='stylesheet'>
    	<link href='{{URL::asset('/css/style.css')}}' type='text/css' rel='stylesheet'>

    </head>
    <body>
        <div class="flex-center position-ref full-height imgWelcome">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif


            <div class="container center imgWelcome font200 fontWhite">
                    <br>
                    <br>
                    <br>
                    <br>
                    ¡Esperanos Pronto! <br> estamos en construcción
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
            </div>
        </div>
    </body>
</html>
