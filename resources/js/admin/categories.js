import axios from 'axios';
import { Modal } from 'bootstrap';

export const AdminCategories = () => {
    return {
        // Данные создания
        createForm: {
            name: ''
        },
        // Данные для удаления
        deleteForm: {
            id: null,
            name: '',
        },
        // Данные для изменения
        editForm: {
            id: null,
            name: ''
        },
        editFormErrors: {},
        // Ошибки валидации
        createFormErrors: {},

        // Сброс формы
        resetCreate() {
            this.createForm.name = '';
            this.createFormErrors = {};
        },

        // Отправка формы создания
        submitCreateForm(event) {
            event.preventDefault();

            const form = event.currentTarget;
            const url = form.getAttribute('action');

            axios.post(url, this.createForm)
                .then(() => {
                    const modalEl = document.getElementById('create-category');
                    const modal = Modal.getInstance(modalEl);
                    this.resetCreate();
                    modal.hide();

                    // ❗️ Перезагрузка страницы для обновления списка
                    window.location.reload();
                })
                .catch(error => {
                    if (error.response?.status === 422) {
                        this.createFormErrors = error.response.data.errors || {};
                    } else {
                        alert('❌ Ошибка сервера');
                        console.error(error);
                    }
                });
        },

        openDeleteModal(category) {
            this.deleteForm.id = category.id;
            this.deleteForm.name = category.name;
            const modal = new bootstrap.Modal(document.getElementById('delete-category'));
            modal.show();
        },
        submitDeleteForm() {
            axios.delete(`/api/categories/${this.deleteForm.id}`)
                .then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('delete-category'));
                    modal.hide();

                    // 💡 Просто перезагружаем страницу для обновления Blade-таблицы
                    window.location.reload();
                })
                .catch(err => {
                    alert('Ошибка при удалении');
                    console.error(err);
                });
        },

        openEditModal(category) {
            this.editForm.id = category.id;
            this.editForm.name = category.name;
            this.editFormErrors = {};
            const modal = new bootstrap.Modal(document.getElementById('edit-category'));
            modal.show();
        },

        submitEditForm() {
            axios.put(`/api/categories/${this.editForm.id}`, { name: this.editForm.name })
                .then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('edit-category'));
                    modal.hide();
                    window.location.reload(); // Обновить таблицу
                })
                .catch(error => {
                    if (error.response?.status === 422) {
                        this.editFormErrors = error.response.data.errors || {};
                    } else {
                        alert('Ошибка при сохранении');
                        console.error(error);
                    }
                });
        },

    };
};
