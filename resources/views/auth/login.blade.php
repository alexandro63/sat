@extends('layouts.auth')
@section('title', __('lang_v1.login'))

@section('content')

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf
        @error('user_name')
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span id="errorMessage">{{ $message }}</span>
            </div>
        @enderror
        @error('password')
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span id="errorMessage">{{ $message }}</span>
            </div>
        @enderror

        <div class="form-group">
            <i class="fas fa-user input-icon"></i>
            <input type="text" class="form-control" id="username" name="user_name" placeholder="Nombre de usuario"
                required autofocus value="{{ old('user_name') }}" @error('user_name') is-invalid @enderror>
        </div>

        <div class="form-group">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            <i class="fas fa-eye password-toggle" onclick="mostrarContrasena()"></i>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-sign text-white" for="remember">
                Recuérdame
            </label>
        </div>

        <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Iniciar Sesión
        </button>

        <a class="btn btn-login mt-2 text-white" onclick="loginEstudiante()">
            <i class="fas fa-book-reader mr-2"></i>
            Estudiante
        </a>

        <a class="btn btn-login mt-2 text-white" onclick="loginDocente()">
            <i class="fas fa-user-tie mr-2"></i>
            Docente
        </a>
    </form>

@endsection
@push('javascript')
    <script type="text/javascript">
        function mostrarContrasena() {
            var tipo = document.getElementById("password");
            if (tipo.type == "password") {
                tipo.type = "text";
                $('.password-toggle').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
            } else {
                tipo.type = "password";
                $('.password-toggle').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
            }
        }

        function loginEstudiante() {
            let username = document.getElementById('username')
            let password = document.getElementById('password')
            username.placeholder = 'Ruc';
            password.placeholder = 'C.I.';
            username.classList.add('input-number')
            password.classList.add('input-number')
            username.focus()
        }

        function loginDocente() {
            let username = document.getElementById('username')
            let password = document.getElementById('password')
            username.placeholder = 'Nombre de usuario'
            password.placeholder = 'Contraseña'
            username.classList.remove('input-number')
            password.classList.remove('input-number')
            username.focus()

        }

        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
@endpush
