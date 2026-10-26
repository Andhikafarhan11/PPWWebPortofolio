<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portfolio Saya')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        
        .pagination {
            display: flex !important;
            flex-direction: row !important;
            list-style: none !important;
            padding-left: 0 !important;
            margin: 0 !important;
            gap: 4px;
        }

        .page-item .page-link {
            border-radius: 6px !important;
            color: #334155;
            border: 1px solid #e2e8f0;
            padding: 6px 12px;
            font-size: 0.875rem;
            text-decoration: none;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #ffffff;
        }

        .page-item.disabled .page-link {
            color: #94a3b8;
            background-color: #f1f5f9;
            border-color: #e2e8f0;
        }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Navigasi Atas --}}
    @include('partials.navbar')

    {{-- Konten Utama (Otomatis mengisi ruang kosong agar footer selalu di bawah) --}}
    <main class="flex-grow-1 py-4">
        @yield('content')
    </main>

    {{-- Navigasi Bawah / Footer --}}
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>