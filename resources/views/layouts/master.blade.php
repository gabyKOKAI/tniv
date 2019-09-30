<!DOCTYPE html>
<html>
<head>
    <title>
        @yield('title', 'VINT Desarrollo Kokai Web')
    </title>

    <meta charset='utf-8'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="/css/vint.css" type='text/css' rel='stylesheet'>
    <link href="/css/generico.css" type='text/css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="{{URL::asset('/js/vint.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script>
    <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->
    <script src="{{URL::asset('/css/Bootstrap/js/bootstrap.min.js')}}"></script>

    @stack('head')

</head>
<body>
    <?php setlocale(LC_TIME, 'es_ES'); ?>
    <header class="imgLogo">
        <div class="container center imgLogo">
            <div class="row">
                <div class="col-sm-3 align-self-left">
                    <!--a class="btn btn-info" href="{{ URL::previous() }}">back</a-->
                </div>
                <div class="col-sm-6 align-self-center">
                    <!--br>
                    VINT
                    <br-->
                    <a href="/">
                        <img src="{{URL::asset('/images/vint.jpg')}}" class="imgLogo2" title="Vint">
                    </a>
                    <!--img src='http://vint.mx/images/vint_blanco.png?crc=31914949' alt='Vint Logo' class="center imgLogo2"-->
                </div>
                <div class="col-md-3">
                    @if (Auth::check())
                        <!--form method='POST' id='logout' action='/logout'>
                            {{ csrf_field() }}
                            <a href='#' onClick='document.getElementById("logout").submit();'>Cerrar Sesión ()</a>
                        </form-->
                    @else
                        <div>¿Ya tienes una cuenta? <a href='/login'>Entra aqui</a></div>
                         <div> ¿Eres nuevo? <a href='/register'>Registrate</a></div>
                    @endif
			    </div>
            </div>
        </div>
    </header>


    @if(session('message'))
        <!--div class='alert'>{{ session('message') }}</div-->
    @endif
    <div class="container center">
        @if (Auth::check())
            @include('layouts.menu')
        @endif
        @include('layouts.message')
    </div>


    <div class="container">
        <div class="container">
           <div class="col-sm-12 align-self-center">
                @yield('breadcrumbs')
            </div>
        </div>
    </div>

    <section>
        <div class="container center">
            <div class="row">
                <div class="col-sm-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    <!--footer>
        &copy; {{ date('Y') }}
    </footer-->

    @stack('body')

</body>
</html>
