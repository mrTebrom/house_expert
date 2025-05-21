@extends('layouts.admin')

@section('title', 'Редактировать проект')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="m-0">Галерея проекта: {{ $project->title }}</h1>

        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mt-4">← Назад к проектам</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="image-gallery"
         x-data="gallerySortable({{ $project->id }})"
         x-init="initSortable()"
         data-project-id="{{ $project->id }}"
         class="row gx-2 gy-4"
    >
        {{-- Область для перетаскивания --}}
        <div id="sortable-wrapper" class="row gx-2 gy-4">
            @foreach($images as $image)
                <div class="col-md-3" data-id="{{ $image->id }}">
                    <div class="card position-relative h-100 d-flex flex-column" style="aspect-ratio: 1 / 1;">
                        {{-- drag-handle --}}
                        <div class="position-absolute top-0 end-0 text-secondary drag-handle bg-dark d-flex gap-1 p-1" style="cursor: move; z-index: 10;">
                            <form method="POST" action="{{ route('admin.projects.images.setMain', [$project, $image]) }}">
                                @csrf
                                <button class="btn btn-sm btn-primary" title="Сделать главным">
                                    @if($image->is_main)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                        </svg>
                                    @endif
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.projects.images.destroy', [$project, $image]) }}" onsubmit="return confirm('Удалить изображение?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Удалить">@include('components.delete')</button>
                            </form>
                            <button class="btn-sm btn btn-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                        </div>

                        {{-- главное --}}
                        @if($image->is_main)
                            <span class="position-absolute top-0 start-0 m-2 badge bg-success z-10">Главное</span>
                        @endif

                        {{-- изображение --}}
                        <div class="flex-grow-1 d-flex">
                            <img src="{{ $image->data_uri }}"
                                 alt="{{ $image->alt }}"
                                 class="w-100"
                                 style="object-fit: cover; aspect-ratio: 1 / 1;" />
                        </div>

                        {{-- кнопки --}}
                        <div class="card-body mt-auto p-2 d-flex justify-content-end gap-2">

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Кнопка "Добавить" вне sortable --}}
        <div class="col-md-3">
            <div class="card h-100 d-flex align-items-center justify-content-center" style="aspect-ratio: 1 / 1;">
                <form method="POST" action="{{ route('admin.projects.images.store', $project) }}"
                      enctype="multipart/form-data"
                      class="text-center w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                    @csrf
                    <input type="file" name="images[]" id="imageUpload" class="d-none" accept="image/*" multiple onchange="this.form.submit()">
                    <label for="imageUpload" class="btn btn-outline-secondary">
                        <div style="font-size: 32px;">＋</div>
                        <small>Добавить</small>
                    </label>
                </form>
            </div>
        </div>
    </div>


@endsection
