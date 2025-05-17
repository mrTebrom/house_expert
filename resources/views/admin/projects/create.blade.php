@extends('layouts.admin')

@section('title', 'Создание проекта')

@section('content')
    <h1 class="mb-4">Создать проект</h1>

    <form method="POST" action="{{ route('admin.projects.store') }}">
        @csrf

        <div class="mb-3">
            <label>Код проекта</label>
            <input type="text" name="project_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Название</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Категория</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Площадь</label>
            <input type="number" step="0.01" name="total_area" class="form-control">
        </div>

        <div class="mb-3">
            <label>Размеры</label>
            <input type="text" name="dimensions" class="form-control">
        </div>

        <div class="mb-3">
            <label>Этажей</label>
            <input type="number" name="floors" class="form-control" value="1">
        </div>

        <div class="form-check mb-3">
            <!-- Обязательно: скрытое поле перед чекбоксом -->
            <input type="hidden" name="has_basement" value="0">

            <label>
                <input type="checkbox" name="has_basement" value="1" {{ old('has_basement') ? 'checked' : '' }}>
                Есть цокольный этаж
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Создать</button>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
