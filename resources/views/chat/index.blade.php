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
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    
    <!-- بررسی وجود کاربر وارد شده -->
    @if (auth()->check())
        <!-- ارسال شناسه کاربر از Blade به جاوااسکریپت -->
        <script>
            window.userId = {{ auth()->user()->id }};
        </script>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <livewire:chat />
    
    </div>

    @livewireScripts
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</body>
</html>
