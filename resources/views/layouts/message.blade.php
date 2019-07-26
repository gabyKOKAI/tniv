<div class="container center">
    <div class="col-sm-12 align-self-center">
        @if (!empty($tipoMensaje))
            <span class="close" data-dismiss="alert">&times;</span>
            <div class="alert-success">
                <strong>{{ $mensaje }}</strong>
            </div>
        @endif
    </div>
</div>
<div class="container-center">
    <div class="row">
        @if ($message = Session::get('success'))
        <div class="col-sm-12 align-self-center alert">
            <span class="close" data-dismiss="alert">&times;</span>
            <div class="alert-success">
                <strong>{{ $message }}</strong>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="container-center">
    <div class="row">
        @if ($message = Session::get('error'))
        <div class="col-sm-12 align-self-center alert">
            <span class="close" data-dismiss="alert">&times;</span>
            <div class="alert-danger">
                <strong>{{ $message }}</strong>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="container-center">
    <div class="row">
        @if ($message = Session::get('warning'))
        <div class="col-sm-12 align-self-center alert">
            <span class="close" data-dismiss="alert">&times;</span>
            <div class="alert-warning">
                <strong>{{ $message }}</strong>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="container-center">
    <div class="row">
        @if ($message = Session::get('info'))
        <div class="col-sm-12 align-self-center alert">
            <span class="close" data-dismiss="alert">&times;</span>
            <div class="alert-info">
                <strong>{{ $message }}</strong>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="container-center">
    <div class="row">
        @if (isset($errors) and $errors->any())
        <div class="col-sm-12  alert">
            <span class="close" data-dismiss="alert">&times;</span>
            <div class="alert-danger">
                <strong>Favor de Verificar los errores:</strong>
            </div>
            <div class="alert-info">
                @if(count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="row">
                        {{ $error }}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        @endif

    </div>
</div>