<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test API</title>
</head>

<body>
    <form action="{{ route('content.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="hidden" name="token" value="">

        <input type="file" name="image">
        <button type="submit">Submit</button>
    </form>
</body>

</html>