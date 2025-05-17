@extends('layouts.admin')

@section('title', 'Слайды')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- СОЗДАНИЕ --}}
    <h2 class="mb-3">Создать слайд</h2>
    <form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Заголовок</label>
            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Ссылка</label>
            <input type="url" name="link" class="form-control" value="{{ old('link') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Картинка</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Создать слайд</button>
    </form>

    {{-- СПИСОК --}}
    <h1 class="my-4">Слайды</h1>
    <div class="row g-4">
        @forelse ($sliders as $slider)
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <img src="data:image/jpeg;base64,{{ $slider->image_base64 }}" class="card-img-top" alt="Слайд">
                    <div class="card-body">
                        <h5 class="card-title">{{ $slider->title }}</h5>
                        @if($slider->description)
                            <p class="card-text">{{ $slider->description }}</p>
                        @endif
                        @if($slider->link)
                            <a href="{{ $slider->link }}" class="btn btn-outline-primary btn-sm" target="_blank">Перейти</a>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" onsubmit="return confirm('Удалить?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                        <button class="btn btn-sm btn-warning" onclick="toggleEditForm({{ $slider->id }})">Редактировать</button>
                    </div>

                    {{-- РЕДАКТИРОВАНИЕ --}}
                    <div id="edit-form-{{ $slider->id }}" class="p-3" style="display: none; border-top: 1px solid #eee;">
                        <form method="POST" action="{{ route('admin.sliders.update', $slider) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-2">
                                <label class="form-label">Заголовок</label>
                                <input type="text" name="title" class="form-control" value="{{ $slider->title }}" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Ссылка</label>
                                <input type="url" name="link" class="form-control" value="{{ $slider->link }}">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Описание</label>
                                <textarea name="description" class="form-control" rows="2">{{ $slider->description }}</textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Новая картинка (если нужна)</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Слайдов нет</p>
        @endforelse
    </div>

    <script>
        function toggleEditForm(id) {
            const form = document.getElementById('edit-form-' + id);
            if (form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
@endsection
