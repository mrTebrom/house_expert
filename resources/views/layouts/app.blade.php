<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Hous Expert')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body>
        <header class="bg-dark text-white">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="/">Hous Expert</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Главная</a>
                            </li>
                        </ul>
                        <div class="d-flex">
                            @auth
                                <div x-data="{ open: false }" class="dropdown">
                                    <button class="btn btn-outline-light dropdown-toggle" type="button" @click="open = !open">
                                        {{ Auth::user()->name }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" x-show="open" @click.away="open = false">
                                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Профиль</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Выйти</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <button type="button" class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    Войти
                                </button>
                                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">
                                    Регистрация
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <main class="container py-4">
            @yield('content')
        </main>

        <!-- Модальное окно входа -->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginModalLabel">Вход</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div x-data="loginForm()">
                            <form @submit.prevent="submitForm" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email"
                                           class="form-control"
                                           :class="{'is-invalid': errors.email}"
                                           id="email"
                                           name="email"
                                           x-model="form.email"
                                           required>
                                    <div class="invalid-feedback" x-text="errors.email"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Пароль</label>
                                    <input type="password"
                                           class="form-control"
                                           :class="{'is-invalid': errors.password}"
                                           id="password"
                                           name="password"
                                           x-model="form.password"
                                           required>
                                    <div class="invalid-feedback" x-text="errors.password"></div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           id="remember"
                                           name="remember"
                                           x-model="form.remember">
                                    <label class="form-check-label" for="remember">Запомнить меня</label>
                                </div>
                                <div x-show="errorMessage" class="alert alert-danger mb-3" x-text="errorMessage"></div>
                                <button type="submit"
                                        class="btn btn-primary w-100"
                                        :disabled="loading">
                                    <span x-show="!loading">Войти</span>
                                    <span x-show="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно регистрации -->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalLabel">Регистрация</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div x-data="registerForm()">
                            <form @submit.prevent="submitForm" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Имя</label>
                                    <input type="text"
                                           class="form-control"
                                           :class="{'is-invalid': errors.name}"
                                           id="name"
                                           name="name"
                                           x-model="form.name"
                                           required>
                                    <div class="invalid-feedback" x-text="errors.name"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="register-email" class="form-label">Email</label>
                                    <input type="email"
                                           class="form-control"
                                           :class="{'is-invalid': errors.email}"
                                           id="register-email"
                                           name="email"
                                           x-model="form.email"
                                           required>
                                    <div class="invalid-feedback" x-text="errors.email"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="register-password" class="form-label">Пароль</label>
                                    <input type="password"
                                           class="form-control"
                                           :class="{'is-invalid': errors.password}"
                                           id="register-password"
                                           name="password"
                                           x-model="form.password"
                                           required>
                                    <div class="invalid-feedback" x-text="errors.password"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                                    <input type="password"
                                           class="form-control"
                                           :class="{'is-invalid': errors.password_confirmation}"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           x-model="form.password_confirmation"
                                           required>
                                    <div class="invalid-feedback" x-text="errors.password_confirmation"></div>
                                </div>
                                <div x-show="errorMessage" class="alert alert-danger mb-3" x-text="errorMessage"></div>
                                <button type="submit"
                                        class="btn btn-primary w-100"
                                        :disabled="loading">
                                    <span x-show="!loading">Зарегистрироваться</span>
                                    <span x-show="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function loginForm() {
                return {
                    form: {
                        email: '',
                        password: '',
                        remember: false
                    },
                    errors: {},
                    loading: false,
                    errorMessage: '',

                    async submitForm() {
                        this.loading = true;
                        this.errors = {};
                        this.errorMessage = '';

                        try {
                            const formData = new FormData();
                            formData.append('email', this.form.email);
                            formData.append('password', this.form.password);
                            formData.append('remember', this.form.remember);
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                            const response = await fetch('{{ route('login') }}', {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData
                            });

                            const data = await response.json();

                            if (!response.ok) {
                                if (response.status === 422) {
                                    this.errors = data.errors;
                                } else {
                                    this.errorMessage = data.message || 'Произошла ошибка при входе';
                                }
                                return;
                            }

                            // Закрываем модальное окно
                            const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                            modal.hide();

                            window.location.reload();
                        } catch (error) {
                            console.error('Error:', error);
                            this.errorMessage = 'Произошла ошибка при отправке формы';
                        } finally {
                            this.loading = false;
                        }
                    }
                }
            }

            function registerForm() {
                return {
                    form: {
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: ''
                    },
                    errors: {},
                    loading: false,
                    errorMessage: '',

                    async submitForm() {
                        this.loading = true;
                        this.errors = {};
                        this.errorMessage = '';

                        try {
                            const formData = new FormData();
                            formData.append('name', this.form.name);
                            formData.append('email', this.form.email);
                            formData.append('password', this.form.password);
                            formData.append('password_confirmation', this.form.password_confirmation);
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                            const response = await fetch('{{ route('register') }}', {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData
                            });

                            const data = await response.json();

                            if (!response.ok) {
                                if (response.status === 422) {
                                    this.errors = data.errors;
                                } else {
                                    this.errorMessage = data.message || 'Произошла ошибка при регистрации';
                                }
                                return;
                            }

                            // Закрываем модальное окно
                            const modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                            modal.hide();

                            window.location.reload();
                        } catch (error) {
                            console.error('Error:', error);
                            this.errorMessage = 'Произошла ошибка при отправке формы';
                        } finally {
                            this.loading = false;
                        }
                    }
                }
            }
        </script>
    </body>
</html>
