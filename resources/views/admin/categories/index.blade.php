@extends('layouts.app')

@section('title', 'Categorie')

@section('actions')
  <div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
      Crea nuova categoria
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
                href="{{ route('admin.categories.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Id
                @if ($sort == 'id')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              <a
                href="{{ route('admin.categories.index') }}?sort=label&order={{ $sort == 'label' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Label
                @if ($sort == 'label')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              <a
                href="{{ route('admin.categories.index') }}?sort=color&order={{ $sort == 'color' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Colore
                @if ($sort == 'color')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              Pill
            </th>

            <th scope="col">
              <a
                href="{{ route('admin.categories.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                Creazione
                @if ($sort == 'created_at')
                  <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                @endif
              </a>
            </th>

            <th scope="col">
              <a
                href="{{ route('admin.categories.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
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
          @forelse($categories as $category)
            <tr>
              <th scope="row">{{ $category->id }}</th>
              <td>{{ $category->label }}</td>
              <td>{{ $category->color }}</td>
              <td>
                {!! $category->getBadgeHTML() !!}
              </td>
              <td>{{ $category->created_at }}</td>
              <td>{{ $category->updated_at }}</td>
              <td>
                {{-- <a href="{{ route('admin.categories.show', $category) }}">
                  <i class="bi bi-eye mx-2"></i>
                </a> --}}

                <a href="{{ route('admin.categories.edit', $category) }}">
                  <i class="bi bi-pencil mx-2"></i>
                </a>

                <a href="#" class="text-danger" data-bs-toggle="modal"
                  data-bs-target="#delete-category-modal-{{ $category->id }}">
                  <i class="bi bi-trash mx-2"></i>
                </a>

              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7">
                Nessun risultato
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{ $categories->links() }}
    </div>
  </section>
@endsection

@section('modals')
  @foreach ($categories as $category)
    <div class="modal modal-lg fade" id="delete-category-modal-{{ $category->id }}" tabindex="-1"
      aria-labelledby="delete-category-modal-{{ $category->id }}-label" aria-hidden="true" data-bs-backdrop="static"
      data-bs-keyboard="false">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="delete-category-modal-{{ $category->id }}-label">Elimina categoria</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Sei sicuro di voler eliminare la categoria "{{ $category->title }}"?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
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
