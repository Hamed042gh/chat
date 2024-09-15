<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    @livewireStyles
    @vite('resources/css/app.css')
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <!-- بررسی وجود کاربر وارد شده -->
    @if (auth()->check())
        <!-- ارسال شناسه کاربر از Blade به جاوااسکریپت -->
        <script>
            window.userId = {{ auth()->user()->id }};
        </script>
    @endif

    <div class="flex w-full max-w-screen-lg bg-white p-6 rounded-lg shadow-lg">
        <!-- بخش چت -->
        <div class="flex-1 p-6 flex flex-col">
            <livewire:chat />
        </div>

        <!-- بخش آنلاین کاربران -->
        <div class="w-1/4 p-6 bg-gradient-to-br from-yellow-200 via-yellow-300 to-yellow-400 rounded-lg shadow-lg ml-6">
            <h3 class="text-2xl font-bold mb-4 text-gray-800">Online Users List</h3>
            <ul id="online-users" class="list-none p-0">
                <!-- لیست کاربران آنلاین -->
            </ul>
        </div>
    </div>

    @livewireScripts
    @vite('resources/js/app.js')
</body>

</html>
