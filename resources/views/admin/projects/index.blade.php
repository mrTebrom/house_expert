@extends('layouts.admin')

@section('title', 'Список проектов')

@section('content')
    <h1 class="mb-4">Проекты</h1>

    <a href="{{ route('admin.projects.create') }}" class="btn btn-success mb-3">Создать новый</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th style="width: 40px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </th>
            <th>Код</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Этажей</th>
            <th>Цоколь</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{ $project->id }}</td>
                <td>
                    @if($project->mainImage)
                        <img src="{{ $project->mainImage->data_uri }}"
                             alt="Главное изображение"
                             class="img-thumbnail"
                             style="width: 32px; aspect-ratio: 1 / 1; object-fit: cover;">
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>{{ $project->project_code }}</td>
                <td>{{ $project->title }}</td>
                <td>{{ $project->category->name ?? '-' }}</td>
                <td>{{ $project->floors }}</td>
                <td>{{ $project->has_basement ? 'Да' : 'Нет' }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('admin.projects.images.index', $project) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">
                        @include('components.edit')
                    </a>
                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить проект?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            @include('components.delete')
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
