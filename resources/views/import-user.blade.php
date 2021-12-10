@extends('welcome')

@section('content')

   <div class="container">
        <h1 class="mt-5">Importar datos</h1>

        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="data" class="form-control">
            <button type="submit" class="btn btn-primary mt-3">Upload</button>
        </form>
   </div>

@endsection