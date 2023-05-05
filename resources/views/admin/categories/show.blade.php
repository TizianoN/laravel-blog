@extends('layouts.app')

@section('title', $category->label)

@section('actions')
  <div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary mx-1">Torna alla lista</a>
    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary mx-1">Modifica Categoria</a>
  </div>
@endsection

@section('content')
  <section class="card clearfix">
    <div class="card-body">
      <p>
        <strong>Categoria: </strong>
        {!! $category?->getBadgeHTML() !!}
      </p>
    </div>
  </section>
@endsection
