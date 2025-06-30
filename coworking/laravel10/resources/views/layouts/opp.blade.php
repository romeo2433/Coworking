<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    @include('layouts.header')

    <div class="dashboard-container">
        @include('layouts.sidebar2')

        <main class="main-content">
            @yield('content')
        </main>
    </div>

    @include('layouts.footer')

</body>
</html>

<style>
    .dashboard-container {
        display: flex;
    }

    .main-content {
        margin-left: 260px;
        padding: 20px;
        width: 100%;
    }
</style>
