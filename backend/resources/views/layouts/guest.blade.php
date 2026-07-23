<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Educonnect') }}</title>

        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style> body { font-family: 'Inter', sans-serif; } </style>
    </head>
    <body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <a href="/" class="inline-flex items-center space-x-3 mb-2">
                <div class="h-12 w-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-md">
                    E
                </div>
                <span class="text-3xl font-extrabold text-gray-900 tracking-tight">Educonnect</span>
            </a>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-6 shadow-sm border border-gray-200 rounded-xl sm:px-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>s