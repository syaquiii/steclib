<!DOCTYPE html>
<html>

<head>
    <title>My App</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen flex flex-col bg-[#EEE7D5]">
    <main class="flex-1">
    @yield('content')
    </main>

    @yield('footer')
</body>

</html>