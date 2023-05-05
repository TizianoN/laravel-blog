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
      <div class="row">
        <div class="col-3">
          <p>
            <strong>Categoria:</strong>
            <br>

            @if ($post->category)
              {!! $post->category->getBadgeHTML() !!}
            @else
              Non categorizzato
            @endif
          </p>
        </div>
        <div class="col-3">
          <p>
            <strong>Tags:</strong>
            <br>
            @forelse ($post->tags as $tag)
              {!! $tag->getBadgeHTML() !!}
            @empty
              Nessun tag associato
            @endforelse
          </p>
        </div>
        <div class="col-3">
          <p>
            <strong>Ultima modifica:</strong>
            <br>
            {{ $post->updated_at }}
          </p>
        </div>
        <div class="col-3">
          <p>
            <strong>Creato il:</strong>
            <br>
            {{ $post->created_at }}
          </p>
        </div>
        <div class="col-12">
          <p>
            <strong>Contenuto: </strong>
            {{ $post->text }}
          </p>
        </div>
      </div>
    </div>
  </section>
@endsection
