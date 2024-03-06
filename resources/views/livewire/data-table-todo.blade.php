<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App template</title>
    {{--<script src="https://cdn.tailwindcss.com"></script>--}}
    @vite('resources/css/app.css')
    @vite('resources/css/app.js')
</head>
<body>

<livewire:navbar/>
    <div class="flex items-center justify-center h-screen">
        <livewire:table/>
    </div>
</body>
</html>
