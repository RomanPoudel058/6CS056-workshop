<!DOCTYPE html> 
<html> 
<head> 
    <title>Students</title> 
</head> 
<body> 
    <h1>Students</h1> 

    <!-- Displays the flashed success message from Step 12 redirect -->
    @if(session('success')) 
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p> 
    @endif 

    <!-- Path fixed from "/students/create" to "/student/create" to match your web.php route -->
    <a href="/student/create">Create Student</a> 
    <br><br>

    <table border="1" cellpadding="10"> 
        <thead> 
            <tr> 
                <th>ID</th> 
                <th>Name</th> 
                <th>Email</th> 
                <th>Phone</th> 
                <th>Actions</th> 
            </tr> 
        </thead> 
        <tbody> 
            @forelse($students as $student) 
                <tr> 
                    <td>{{ $student->id }}</td> 
                    <td>{{ $student->name }}</td> 
                    <td>{{ $student->email }}</td> 
                    <td>{{ $student->phone }}</td> 
                    <td> 
                        <a href="/students/{{ $student->id }}">View</a> 
                        <a href="/students/{{ $student->id }}/edit">Edit</a> 
                        
                        <form 
                            action="/students/{{ $student->id }}" 
                            method="POST" 
                            style="display:inline" 
                        > 
                            @csrf 
                            @method('DELETE') 
                            <button type="submit">Delete</button> 
                        </form> 
                    </td> 
                </tr> 
            @empty 
                <tr> 
                    <td colspan="5" style="text-align: center;"> 
                        No students found. 
                    </td> 
                </tr> 
            @endforelse 
        </tbody> 
    </table> 
</body> 
</html>
