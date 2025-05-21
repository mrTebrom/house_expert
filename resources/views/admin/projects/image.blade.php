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
         class="row gx-2 gy-5"
    >
        @foreach($images as $image)
            <div class="col-md-3 d-flex">
                <div class="card w-100 position-relative d-flex flex-column"
                     style="aspect-ratio: 1 / 1; height: auto; min-height: 260px; overflow: hidden;">

                    {{-- drag handle --}}
                    <div class="position-absolute top-0 end-0 p-2 text-secondary drag-handle bg-dark"
                         style="cursor: move; z-index: 10;">☰</div>

                    {{-- главное --}}
                    @if($image->is_main)
                        <span class="position-absolute top-0 start-0 m-2 badge bg-success z-10">Главное</span>
                    @endif

                    {{-- картинка --}}
                    <div class="flex-grow-1 d-flex">
                        <img src="{{ $image->data_uri }}"
                             alt="{{ $image->alt }}"
                             class="w-100"
                             style="object-fit: cover; aspect-ratio: 1 / 1;" />
                    </div>

                    {{-- кнопки --}}
                    <div class="card-body mt-auto p-2 d-flex justify-content-end gap-2">
                        <form method="POST" action="{{ route('admin.projects.images.setMain', [$project, $image]) }}">
                            @csrf
                            <button class="btn btn-sm btn-primary" title="Сделать главным">
                                @if($image->is_main)
                                    ✔
                                @else
                                    ☆
                                @endif
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.projects.images.destroy', [$project, $image]) }}"
                              onsubmit="return confirm('Удалить изображение?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Удалить">🗑</button>
                        </form>
                    </div>
                </div>
            </div>


        @endforeach
        <div class="col-md-3">
            <div class="card h-100 d-flex align-items-center justify-content-center" style="aspect-ratio: 1 / 1;">
                <form method="POST" action="{{ route('admin.projects.images.store', $project) }}" enctype="multipart/form-data" class="text-center w-100 h-100 d-flex flex-column justify-content-center align-items-center">
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
