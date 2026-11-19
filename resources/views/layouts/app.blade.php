<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaon Ta! Davao – Serra's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
@include('partials.nav')
@include('partials.flash')
<main class="max-w-6xl mx-auto px-4 py-6">
    @yield('content')
</main>
</body>
</html>
