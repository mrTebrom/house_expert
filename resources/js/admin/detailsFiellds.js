import axios from 'axios';
import { Modal } from 'bootstrap';

export const AdminDetailFields = () => {
    return {
        fields: [],
        createForm: { label: '', type: 'string' },
        editForm: { id: null, label: '', type: '' },
        deleteForm: { id: null, label: '' },

        fetchFields() {
            axios.get('/api/detail-fields')
                .then(res => this.fields = res.data)
                .catch(err => alert('Ошибка загрузки полей'));
        },

        submitCreateForm() {
            axios.post('/api/detail-fields', this.createForm)
                .then(() => {
                    Modal.getInstance(document.getElementById('create-field')).hide();
                    this.createForm = { label: '', type: 'string' };
                    this.fetchFields();
                })
                .catch(err => alert('Ошибка при создании'));
        },

        openEditModal(field) {
            this.editForm = { ...field };
            new Modal(document.getElementById('edit-field')).show();
        },

        submitEditForm() {
            axios.put(`/api/detail-fields/${this.editForm.id}`, this.editForm)
                .then(() => {
                    Modal.getInstance(document.getElementById('edit-field')).hide();
                    this.fetchFields();
                })
                .catch(err => alert('Ошибка при обновлении'));
        },

        openDeleteModal(field) {
            this.deleteForm = { ...field };
            new Modal(document.getElementById('delete-field')).show();
        },

        submitDeleteForm() {
            axios.delete(`/api/detail-fields/${this.deleteForm.id}`)
                .then(() => {
                    Modal.getInstance(document.getElementById('delete-field')).hide();
                    this.fetchFields();
                })
                .catch(err => alert('Ошибка при удалении'));
        },

        init() {
            this.fetchFields();
        }
    };
};
