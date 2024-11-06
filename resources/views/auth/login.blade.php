<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<!-- <body class="bg-light d-flex align-items/-center" style="min-height: 100vh; background-image: url('{{ asset('vendor/yourpackage/background-image.jpg') }}'); background-size: cover;"> -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg mt-5">
                    <div class="card-body">
                        <h3 class="text-center mb-4 text-success">Login</h3>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    placeholder="Email"
                                    class="form-control w-100" 
                                    value="{{ old('email') }}"
                                    required
                                >
                                <label for="password" class="form-label">Password</label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    placeholder="Password"
                                    class="form-control w-100" 
                                    value="{{ old('password') }}"
                                    required
                                >
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success w-100">Login</button>
                            </div>
                            <div class="text-center mt-3">
                                <a href="/forgot-password">Forgot password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>