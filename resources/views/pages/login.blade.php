<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <title>Data Mining</title>
    </head>
    <body>
        <div class="bg-dark-subtle position-absolute top-50 start-50 translate-middle w-25 p-4 rounded">
            @if(session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif
            @if($errors->any())
                @foreach($errors->all() as $err)
                    <p class="alert alert-danger">{{ $err }}</p>
                @endforeach
            @endif
            <form action="{{ route('login.action') }}" method="POST">
                @csrf
                <h2 class="fw-bold text-center mb-3">LOGIN</h2>
                <div class="mb-3">
                    <label>Username <span class="text-danger">*</span></label>
                    <input class="form-control" type="username" name="username" value="{{ old('username') }}" />
                </div>
                <div class="mb-3">
                    <label>Password <span class="text-danger">*</span></label>
                    <input class="form-control" type="password" name="password" />
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary w-100">Login</button>
                </div>
            </form>
        </div>
    </body>
</html>
