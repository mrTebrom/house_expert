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
                <td>{{ $project->project_code }}</td>
                <td>{{ $project->title }}</td>
                <td>{{ $project->category->name ?? '-' }}</td>
                <td>{{ $project->floors }}</td>
                <td>{{ $project->has_basement ? 'Да' : 'Нет' }}</td>
                <td>
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">✏️</a>
                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить проект?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
