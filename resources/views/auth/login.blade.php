<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/coffee.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    {!! showalerts() !!}
    <!-- auth-page wrapper -->
    <div class="min-vh-100 p-5" style="background-image: url('{{ asset('img/bg.jpg') }}'); background-size: cover;">
        <div class="container p-5">
            <div class="card w-50 m-auto">
                <div class="card-body">
                    <div class="text-center">
                        <img class="mt-4 mb-4" src="{{ asset('img/logo.png') }}" style="height: 100px;">
                    </div>
                    <div class="p-2">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ __('auth.username') }}</label>
                                <input type="text" name="username" value="{{ old('username') }}" required autofocus class="form-control @error('username') is-invalid @enderror" placeholder="Saisissez votre nom d'utilisateur">
                                @error('username')<span class="invalid-feedback" role="alert">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('auth.password') }}</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" name="password" id="password-input" required class="form-control pe-5" placeholder="Saisissez votre mot de passe">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                <label class="form-check-label" for="auth-remember-check">{{ __('auth.remember') }}</label>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">{{ __('auth.login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end auth-page-wrapper -->
</body>
</html>
