<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Training Institute')</title>
</head>
<body>
    <nav>
        <a href="{{ route('students.index') }}">Students</a> |
        <a href="{{ route('courses.index') }}">Courses</a>
    </nav>
    <hr>

    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
    @endif

    @yield('content')
</body>
</html>
