@extends('layouts.admin')

@section('title', 'Поля проекта')

@section('content')
    <div x-data="AdminDetailFields()">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Поля проекта</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-field">Добавить поле</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th class="action">Действия</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="field in fields" :key="field.id">
                    <tr>
                        <td x-text="field.id"></td>
                        <td x-text="field.label"></td>
                        <td x-text="field.type"></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-warning btn-sm" @click="openEditModal(field)">Изменить</button>
                                <button class="btn btn-danger btn-sm" @click="openDeleteModal(field)">Удалить</button>
                            </div>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>

        <!-- Модалка создания -->
        <div class="modal fade" id="create-field" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" x-data>
                    <div class="modal-header">
                        <h5 class="modal-title">Создать поле</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitCreateForm">
                            <div class="mb-3">
                                <label>Название</label>
                                <input type="text" class="form-control" x-model="createForm.label">
                            </div>
                            <div class="mb-3">
                                <label>Тип</label>
                                <select class="form-control" x-model="createForm.type">
                                    <option value="string">Строка</option>
                                    <option value="number">Число</option>
                                    <option value="boolean">Булево</option>
                                    <option value="text">Текст</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Создать</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модалка редактирования -->
        <div class="modal fade" id="edit-field" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" x-data>
                    <div class="modal-header">
                        <h5 class="modal-title">Изменить поле</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitEditForm">
                            <div class="mb-3">
                                <label>Название</label>
                                <input type="text" class="form-control" x-model="editForm.label">
                            </div>
                            <div class="mb-3">
                                <label>Тип</label>
                                <select class="form-control" x-model="editForm.type">
                                    <option value="string">Строка</option>
                                    <option value="number">Число</option>
                                    <option value="boolean">Булево</option>
                                    <option value="text">Текст</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модалка удаления -->
        <div class="modal fade" id="delete-field" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" x-data>
                    <div class="modal-header">
                        <h5 class="modal-title">Удалить поле</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Удалить поле "<span x-text="deleteForm.label"></span>"?</p>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-danger" @click="submitDeleteForm()">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
