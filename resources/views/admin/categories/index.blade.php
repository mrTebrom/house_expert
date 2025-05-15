@extends('layouts.admin')

@section('title', 'Категории')

@section('content')
    <div  x-data="AdminCategories()">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Категории</h1>
            <button
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#create-category"
            >Создать категорию</button>
        </div>

        <!-- Таблица -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th class="action">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <div class="d-flex gap-1">

                                <button
                                    class="btn btn-danger btn-sm"
                                    @click="openDeleteModal({ id: {{ $category->id }}, name: '{{ $category->name }}' })"
                                >
                                    @include('components.delete')
                                    Удалить
                                </button>
                                <button @click="openEditModal({ id: {{ $category->id }}, name: '{{ $category->name }}' })" class="btn btn-warning btn-sm">
                                    @include('components.edit')
                                    Изменить
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        <div class="mt-3">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>

        <!-- Модалка изменения -->
        <div class="modal fade" id="edit-category" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" x-data>
                    <div class="modal-header">
                        <h5 class="modal-title">Редактировать категорию</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitEditForm">
                            <div class="mb-3">
                                <label class="form-label">Название</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    x-model="editForm.name"
                                    required
                                    :class="{ 'is-invalid': editFormErrors.name }"
                                />
                                <template x-if="editFormErrors.name">
                                    <div class="invalid-feedback" x-text="editFormErrors.name[0]"></div>
                                </template>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модалка удаление -->
        <div class="modal fade" id="delete-category" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" x-data>
                    <div class="modal-header">
                        <h5 class="modal-title">Удалить категорию</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Вы действительно хотите удалить "<span x-text="deleteForm.name"></span>"?</p>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-danger" @click="submitDeleteForm()">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Модалка создания -->
        <div class="modal fade" id="create-category" tabindex="-1" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Создать категорию</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form
                            @submit.prevent="submitCreateForm"
                            method="POST"
                            action="{{ route('admin.categories.store') }}"
                        >
                            @csrf
                            <div>
                                <label class="form-label">Название категорий</label>
                                <input
                                    class="form-control"
                                    placeholder="Введите название категорий"
                                    x-model="createForm.name"
                                    required
                                    :class="{ 'is-invalid': createFormErrors.name }"
                                />
                                <template x-if="createFormErrors.name">
                                    <div class="invalid-feedback" x-text="createFormErrors.name[0]"></div>
                                </template>
                            </div>
                            <div class="d-flex gap-3 mt-3 flex-column">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
