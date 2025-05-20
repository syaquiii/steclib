<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class=" bg-[#EEE7D5] ">
    <div class="flexrelative ">
        @include('admin.layout.sidebar')
        <main class="mt-36  absolute right-0 h-screen top-0 px-40 w-4/5">
            @yield('content')
        </main>
    </div>
</body>

</html>