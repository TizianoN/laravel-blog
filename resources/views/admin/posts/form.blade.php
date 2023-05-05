@extends('layouts.app')

@section('title', $post->id ? 'Modifica Post ' . $post->title : 'Crea Post')

@section('actions')
  <div>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-primary mx-1">
      Torna alla lista
    </a>

    @if ($post->id)
      <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-primary mx-1">
        Mostra Post
      </a>
    @endif
  </div>
@endsection

@section('content')

  @include('layouts.partials.errors')

  <section class="card py-2">
    <div class="card-body">

      @if ($post->id)
        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="row">
          @method('put')
        @else
          <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="row">
      @endif

      @csrf

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="title" class="form-label">Titolo</label>
        </div>
        <div class="col-md-10">
          <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $post->title) }}" />
          @error('title')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="category_id" class="form-label">Categoria</label>
        </div>
        <div class="col-md-10">
          <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
            <option value="">Non categorizzato</option>
            @foreach ($categories as $category)
              <option @if (old('category_id', $post->category_id) == $category->id) selected @endif value="{{ $category->id }}">{{ $category->label }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label class="form-label">Tags</label>
        </div>
        <div class="col-md-10">

          <div class="form-check @error('tags') is-invalid @enderror p-0">

            @foreach ($tags as $tag)
              <input type="checkbox" id="tag-{{ $tag->id }}" value="{{ $tag->id }}" name="tags[]"
                class="form-check-control" @if (in_array($tag->id, old('tags', $post_tags ?? []))) checked @endif>
              <label for="tag-{{ $tag->id }}">{{ $tag->label }}</label>
              <br>
            @endforeach


          </div>

          @error('tags')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>


      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="is_published" class="form-label">Pubblicato</label>
        </div>
        <div class="col-md-10">
          <input type="checkbox" name="is_published" id="is_published"
            class="form-check-control @error('is_published') is-invalid @enderror" @checked(old('is_published', $post->is_published))
            value="1" />
          @error('is_published')
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
          <img src="{{ $post->getImageUri() }}" class="img-fluid" alt="" id="image-preview">

          @if ($post->image)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
              id="delete-post-image">
              x
            </span>
          @endif

        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-2 text-end">
          <label for="text" class="form-label">Testo</label>
        </div>
        <div class="col-md-10">
          <textarea name="text" id="text" class="form-control
             @error('text') is-invalid @enderror"
            rows="5">{{ old('text', $post->text) }}</textarea>
          @error('text')
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

      @if ($post->image)
        <form id="delete-post-image-form" method="POST" action="{{ route('admin.posts.delete-image', $post) }}">
          @method('delete')
          @csrf

        </form>
      @endif
    </div>
  </section>
@endsection

@section('scripts')

  @if ($post->image)
    <script>
      const deleteImagebutton = document.getElementById('delete-post-image');
      const deleteImageForm = document.getElementById('delete-post-image-form');

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
