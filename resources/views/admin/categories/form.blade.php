@extends('layouts.app')

@section('title', $category->id ? 'Modifica Categoria ' . $category->label : 'Crea Categoria')

@section('actions')
  <div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mx-1">
      Torna alla lista
    </a>

    {{-- @if ($category->id)
      <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-primary mx-1">
        Mostra Categoria
      </a>
    @endif --}}
  </div>
@endsection

@section('content')

  @include('layouts.partials.errors')

  <section class="card py-2">
    <div class="card-body">

      @if ($category->id)
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data"
          class="row">
          @method('put')
        @else
          <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="row">
      @endif

      @csrf

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="label" class="form-label">Label</label>
        </div>
        <div class="col-md-10">
          <input type="text" name="label" id="label" class="form-control @error('label') is-invalid @enderror"
            value="{{ old('label', $category->label) }}" />
          @error('label')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="color" class="form-label">Colore</label>
        </div>
        <div class="col-md-10">
          <input type="color" name="color" id="color" class="form-control @error('color') is-invalid @enderror"
            value="{{ old('color', $category->color) }}" />
          @error('color')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>


      <div class="row">
        <div class="offset-2 col-8">
          <input type="submit" class="btn btn-primary" value="Salva" />
        </div>
      </div>
      </form>

    </div>
  </section>
@endsection
