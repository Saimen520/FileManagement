<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

    <h2 class="text-center">File Management System</h2>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Upload File Form -->
    <form action="{{ url('/upload-file') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Upload File</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <h3>Uploaded Files</h3>

    <!-- File Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>File Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr>
                    <td>{{ $file->id }}</td>
                    <td>{{ $file->name }}</td>
                    <td>
                        <a href="{{ url('/api/download/' . $file->id) }}" class="btn btn-success">Download</a>
                        <form action="{{ url('/api/delete/' . $file->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
