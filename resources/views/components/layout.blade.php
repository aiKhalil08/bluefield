<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf" content="{{csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{$title}}</title>
</head>
<body>
    <header>
        <div class="mobile-sidebar-controller">X</div>
        <div>Name: {{$name}}</div>
        <div>Role: {{$role}}</div>
        <button id="logout-button" class="button executor" name="logout" data-type="{{$role}}" data-action="logout">LO</div>
    </header>
    <aside class="default">
        <header>
            <div id="aside-info">
                <p>Name: {{$name}}</p>
                <p>Role: {{$role}}</p>
                {{-- <p>Maybe somthing else</p> --}}
            </div>
            <div class="desktop-sidebar-controller grey-font">X</div>
        </header>
        {{-- {{$sidebar}} --}}
        <ul>
        {{-- @foreach (['red', 'blue', 'green', 'red', 'blue', 'green', 'red', 'blue', 'green', 'red', 'blue', 'green','red', 'blue', 'green', 'red', 'blue', 'green','red', 'blue', 'green', 'red', 'blue', 'green','red', 'blue', 'green', 'red',] as $item) --}}
            <li><a href='{{route('doctor.create')}}'>Create doctor</a></li>
        {{-- @endforeach --}}
    </ul>
    </aside>
    <main class="default">
    <div class="page-load-spinner"></div>
    {{$slot}}
    </main>
    <footer>
        <div>&copy; {{date('Y')}}, Bluefield Clinic. All rights reserved.</div>
    </footer>
</body>
</html>
