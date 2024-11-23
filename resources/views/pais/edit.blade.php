<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Edit Country</title>
  </head>
  <body>
    <div class="container">
        <h1>Edit County</h1>
        <form method="POST" action="{{ route('paises.update',['pais'=>$pais->pais_codi])}}">
            @method('put')
            @csrf
              <div class="mb-3">
                <label for="id" class="form-label">Code</label>
                <input type="text" class="form-control" id="id" aria-describedby="idHelp" name="id" disabled="disabled" value="{{$pais->pais_codi}}">
                <div id="idHelp" class="form-text">Country code</div>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Country</label>
                <input type="text" required class="form-control" id="name" aria-activedescendant="nameHelp" name="name" 
                    placeholder="Country name." value="{{$pais->pais_nomb}}">
              </div>
  
              <label for="municipio">Municipality</label>
              <select class="form-select" id="municipio" name="code" required>
                <option selected disabled value="">Seleccionar Uno...</option>
                @foreach ($municipios as $municipio )
                @if ($municipio->muni_codi ==$pais->pais_capi)
                <option selected value="{{$municipio->muni_codi}}">{{$municipio->muni_nomb}}</option>
                @else
                <option value="{{$municipio->muni_codi}}">{{$municipio->muni_nomb}}</option>   
                
                @endif   
                @endforeach
            </select>
              <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('paises.index') }}" class="btn btn-warning">Cancel</a>
              </div>
            </form>
    </div>