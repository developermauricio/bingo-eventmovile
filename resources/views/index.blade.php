@extends('welcome')

@section('content')
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{session('error')}}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <form class="form" method="POST" action="{{route('download')}}">
                    @csrf
                    <h1>Descarga tu tabla de bingo</h1>
                    <input class="form-control" type="email" name="email">
                    <button class="btn btn-primary">Descargar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
