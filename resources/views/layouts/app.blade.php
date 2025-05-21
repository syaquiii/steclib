<!DOCTYPE html>
<html>

<head>
    <title>My App</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="h-full bg-[#EEE7D5]">
    @yield('content')
</body>

</html>