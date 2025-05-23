<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div>

    <main class="container-fluid">
        <div class="row">
            <div class="col-md-2 pt-3">
                <ul class="list-group">
                    <li class="list-group-item">An item</li>
                    <li class="list-group-item">A second item</li>

                    <li class="list-group-item list-group-item-action {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.sliders.index') }}">Слайдер</a>
                    </li>
                    <li class="list-group-item list-group-item-action {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">Категорий</a>
                    </li>
                    <li class="list-group-item list-group-item-action {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">Детали проекта</a>
                    </li>
                    <li class="list-group-item list-group-item-action {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.projects.index') }}">Проекты</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </main>
</div>
</body>
</html>
