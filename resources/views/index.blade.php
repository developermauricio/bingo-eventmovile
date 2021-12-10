@extends('welcome')

@section('content')
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{session('error')}}
            </div>
        @endif

        <div class="main-content">
            <div class="second-content">
                <h1 class="mb-3">Descarga tu tabla de bingo</h1>
                <p class="mb-5 pwidth">Ingresa tu correo electrónico con el cual ingresaste a la plataforma para poder descargar tu tabla de bingo.</p>

                <form class="form" method="POST" action="{{route('download')}}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese su correo" required aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text"></div>
                    </div>

                    <button class="btn btn-primary">Descargar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
