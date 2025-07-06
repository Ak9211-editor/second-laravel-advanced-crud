<!DOCTYPE html>
<html lang="en"
      x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
      x-bind:class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val))"
      class="bg-white dark:bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Advanced CRUD</title>

    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CDN (if needed directly) -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900">

    <div class="min-h-screen py-4 px-3">
        <div class="container">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4 fw-bold">Laravel Advanced CRUD</h1>

                <!-- Dark/Light Mode Toggle Button -->
                <button @click="darkMode = !darkMode" class="btn btn-outline-secondary">
                    Toggle <span x-text="darkMode ? 'Light' : 'Dark'"></span> Mode
                </button>
            </div>

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

</body>
</html>
