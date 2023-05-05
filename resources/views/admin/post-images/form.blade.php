@extends('layouts.app')

@section('title',
  $post_image->id
  ? 'Modifica immagine del post' . $post->title
  : 'Aggiungi nuova immagine
  al post ' . $post->title)

@section('actions')
  {{-- <div>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary mx-1">
      Torna alla lista
    </a>

    @if ($post->id)
      <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary mx-1">
        Mostra Post
      </a>
    @endif
  </div> --}}
@endsection

@section('content')

  @include('layouts.partials.errors')

  <section class="card py-2">
    <div class="card-body">

      @if ($post_image->id)
        <form method="POST" action="{{ route('admin.post-images.update', $post_image) }}" enctype="multipart/form-data"
          class="row">
          @method('put')
        @else
          <form method="POST" action="{{ route('admin.post-images.store') }}" enctype="multipart/form-data" class="row">
      @endif

      @csrf

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="title" class="form-label">Titolo</label>
        </div>
        <div class="col-md-10">
          <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $post_image->title) }}" />
          @error('title')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="image" class="form-label">Immagine</label>
        </div>
        <div class="col-md-8">
          <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" />
          @error('image')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="col-2 position-relative">
          <img src="{{ $post_image->getImageUri() }}" class="img-fluid" alt="" id="image-preview">

          @if ($post_image->image)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
              id="delete-post-images-image">
              x
            </span>
          @endif

        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="content" class="form-label">Testo</label>
        </div>
        <div class="col-md-10">
          <textarea name="content" id="content" class="form-control
             @error('content') is-invalid @enderror"
            rows="5">{{ old('content', $post_image->content) }}</textarea>
          @error('content')
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

      <input type="hidden" name="post_id" value="{{ $post->id }}">

      </form>

      @if ($post_image->image)
        <form id="delete-post-images-image-form" method="POST"
          action="{{ route('admin.post-images.delete-image', $post_image) }}">
          @method('delete')
          @csrf

        </form>
      @endif
    </div>
  </section>
@endsection

@section('scripts')

  @if ($post_image->image)
    <script>
      const deleteImagebutton = document.getElementById('delete-post-images-image');
      const deleteImageForm = document.getElementById('delete-post-images-image-form');

      deleteImagebutton.addEventListener('click', () => {
        deleteImageForm.submit();
      })
    </script>
  @endif


  <script>
    const imageInputEl = document.getElementById('image');
    const imagePreviewEl = document.getElementById('image-preview');
    const placeholder = imagePreviewEl.src;

    imageInputEl.addEventListener('change', () => {
      if (imageInputEl.files && imageInputEl.files[0]) {
        const reader = new FileReader();
        reader.readAsDataURL(imageInputEl.files[0]);

        reader.onload = e => {
          imagePreviewEl.src = e.target.result;
        }
      } else imagePreviewEl.src = placeholder;
    })
  </script>
@endsection
