@extends('layouts.admin')

@section('title', 'Редактировать проект')

@section('content')
    <h1 class="mb-4">Редактировать проект: {{ $project->title }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.projects.update', $project) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Код проекта</label>
            <input type="text" name="project_code" class="form-control" required
                   value="{{ old('project_code', $project->project_code) }}">
        </div>

        <div class="mb-3">
            <label>Название</label>
            <input type="text" name="title" class="form-control" required
                   value="{{ old('title', $project->title) }}">
        </div>

        <div class="mb-3">
            <label>Категория</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Площадь (м²)</label>
            <input type="number" name="total_area" step="0.01" class="form-control"
                   value="{{ old('total_area', $project->total_area) }}">
        </div>

        <div class="mb-3">
            <label>Размеры</label>
            <input type="text" name="dimensions" class="form-control"
                   value="{{ old('dimensions', $project->dimensions) }}">
        </div>

        <div class="mb-3">
            <label>Этажей</label>
            <input type="number" name="floors" class="form-control" min="1"
                   value="{{ old('floors', $project->floors) }}">
        </div>

        <div class="form-check mb-3">
            <!-- hidden input ставится ДО чекбокса -->
            <input type="hidden" name="has_basement" value="0">
            <input type="checkbox" name="has_basement" value="1" {{ old('has_basement', $project->has_basement) ? 'checked' : '' }}>

            <label class="form-check-label" for="has_basement">Есть цокольный этаж</label>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Назад к списку</a>
    </form>
@endsection
