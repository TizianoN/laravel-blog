@extends('layouts.app')

@section('title', 'Gallery del post ' . $post->title)

@section('actions')
  <div>
    <a href="{{ route('admin.post-images.create-by-post', $post) }}" class="btn btn-primary">
      Aggiungi immagine a questo post
    </a>
  </div>
@endsection

@section('content')
  <section class="card">
    <div class="card-body">
      <div class="row">

        @forelse($post->images as $post_image)
          <div class="col-4">
            <div class="card">
              <img src="{{ $post_image->getImageUri() }}" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">{{ $post_image->title }}</h5>
                <p class="card-text">{{ $post_image->content }}</p>
                <div class="d-flex">
                  <form action="{{ route('admin.post-images.destroy', $post_image) }}" method="POST">
                    @method('delete')
                    @csrf

                    <button type="submit" href="#" class="btn btn-danger">Elimina</button>
                  </form>
                  <a href="{{ route('admin.post-images.edit', $post_image) }}" class="btn btn-primary">Modifica</a>

                </div>
              </div>
            </div>
          </div>
        @empty
          <h2>Nessuna immagine</h2>
        @endforelse
      </div>
    </div>
  </section>
@endsection
