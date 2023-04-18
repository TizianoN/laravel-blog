@extends('layouts.app')

@section('title', $post->title)

@section('actions')
  <div>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary mx-1">Torna alla lista</a>
    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary mx-1">Modifica Post</a>
  </div>
@endsection

@section('content')
  <section class="card clearfix">
    <div class="card-body">
      <figure class="float-end ms-5 mb-3">
        <img src="{{ $post->getImageUri() }}" alt="{{ $post->slug }}" width="300">
        <figcaption>
          <p class="text-muted text-secondary m-0">{{ $post->slug }}</p>
        </figcaption>
      </figure>
      <p>
        <strong>Categoria: </strong>
        <span class="badge rounded-pill"
          style="background-color: {{ $post->category?->color }}">{{ $post->category?->label }}</span>
      </p>
      <p>
        <strong>Contenuto: </strong>
        {{ $post->text }}
      </p>
    </div>
  </section>
@endsection
