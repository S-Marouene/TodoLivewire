<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App template</title>
    @vite('resources/css/app.css')
    @vite('resources/css/app.js')
</head>

<body>

<livewire:navbar/>

<div id="content" class="mx-auto" style="max-width:500px;">
    {{--@livewire('todoList',['lazy'=>true])--}}
    {{--OR the same--}}
    <livewire:todolist search="{{request('search')}}" lazy/>
</div>

</body>
</html>
