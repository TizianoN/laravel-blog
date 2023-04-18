@extends('layouts.app')

@section('title', 'Posts')

@section('actions')
  <div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
      Crea nuovo post
    </a>
    <a href="{{ route('admin.posts.trash') }}" class="btn btn-secondary">
      Cestino
    </a>
  </div>
@endsection

@section('content')
  <section class="card">
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">
              <a
                href="{{ route('admin.posts.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Id
                @if ($sort == 'id')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>
            <th scope="col">
              <a
                href="{{ route('admin.posts.index') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Titolo
                @if ($sort == 'title')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>
            <th scope="col">
              Categoria
            </th>
            <th scope="col">
              <a
                href="{{ route('admin.posts.index') }}?sort=text&order={{ $sort == 'text' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Abstract
                @if ($sort == 'text')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              <a
                href="{{ route('admin.posts.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Creazione
                @if ($sort == 'created_at')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              <a
                href="{{ route('admin.posts.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Ultima modifica
                @if ($sort == 'updated_at')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          @forelse($posts as $post)
            <tr>
              <th scope="row">{{ $post->id }}</th>
              <td>{{ $post->title }}</td>
              <td>{{ $post->category?->label }}</td>
              <td>{{ $post->getAbstract(15) }}</td>
              <td>{{ $post->created_at }}</td>
              <td>{{ $post->updated_at }}</td>
              <td>
                <a href="{{ route('admin.posts.show', $post) }}">
                  <i class="bi bi-eye mx-2"></i>
                </a>

                <a href="{{ route('admin.posts.edit', $post) }}">
                  <i class="bi bi-pencil mx-2"></i>
                </a>

                <a href="#" class="text-danger" data-bs-toggle="modal"
                  data-bs-target="#delete-post-modal-{{ $post->id }}">
                  <i class="bi bi-trash mx-2"></i>
                </a>

              </td>
            </tr>
          @empty
          @endforelse
        </tbody>
      </table>

      {{ $posts->links() }}
    </div>
  </section>
@endsection

@section('modals')
  @foreach ($posts as $post)
    <div class="modal modal-lg fade" id="delete-post-modal-{{ $post->id }}" tabindex="-1"
      aria-labelledby="delete-post-modal-{{ $post->id }}-label" aria-hidden="true" data-bs-backdrop="static"
      data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="delete-post-modal-{{ $post->id }}-label">Delete Post</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Sei sicuro di voler eliminare il post "{{ $post->title }}"?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}">
              @method('delete')
              @csrf

              <button type="submit" class="btn btn-danger">Elimina</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach
@endsection
