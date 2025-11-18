<!DOCTYPE html>
<html lang="en" data-sidenav-size="{{ $sidenav ?? 'default' }}" data-layout-mode="{{ $layoutMode ?? 'fluid' }}" data-layout-position="{{ $position ?? 'fixed' }}" data-menu-color="{{ $menuColor ?? 'dark' }}" data-topbar-color="{{ $topbarColor ?? 'light' }}">

<head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<script src="{{ asset('js/script.js') }}"></script>


    @include('front/layouts.shared/title-meta', ['title' => $title])
    @yield('css')
    @include('front/layouts.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])
</head>

<body>
             @include('front/layouts.shared/topbar',['page_title' => $title])
             @yield('content')
             @include('front/layouts.shared/footer')


    @yield('modal')

    @include('layouts.shared/footer-scripts')

    @vite(['resources/js/layout.js', 'resources/js/main.js'])

</body>

</html>
