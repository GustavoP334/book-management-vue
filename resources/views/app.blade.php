<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Management</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="antialiased">    
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-500 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-black">
        <div class="container-md">
            <main class="py-4">
                <div id="app"></div>
            </main>
        </div>
    </div>
</body>
</html>