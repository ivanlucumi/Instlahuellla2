<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Acceso Institutional') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('panelAdmin/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary: #EB1616;
            --secondary: #191C24;
            --light: #6C7293;
            --dark: #000000;
            --glass: rgba(25, 28, 36, 0.85);
            --glass-border: rgba(235, 22, 22, 0.2);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)), 
                        url('{{ asset('panelAdmin/img/institutional_hero.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05), transparent);
            transition: 0.5s;
        }

        .glass-card:hover::before {
            left: 100%;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            max-height: 80px;
            filter: drop-shadow(0 0 10px rgba(235, 22, 22, 0.3));
            animation: pulse 2s infinite;
        }

        .form-floating > .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 10px;
        }

        .form-floating > .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(235, 22, 22, 0.25);
        }

        .form-floating > label {
            color: var(--light);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px var(--primary);
            background: #d11313;
        }

        .btn-link {
            color: var(--light);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .btn-link:hover {
            color: var(--primary);
        }

        .form-check-label {
            color: var(--light);
            font-size: 0.9rem;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .invalid-feedback {
            color: #ff4d4d;
        }

        /* Float background elements */
        .bg-circles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            background: var(--primary);
            filter: blur(80px);
            border-radius: 50%;
            opacity: 0.15;
            animation: float 20s infinite alternate;
        }

        @keyframes float {
            from { transform: translate(0, 0); }
            to { transform: translate(100px, 100px); }
        }
    </style>
</head>
<body>
    <div class="bg-circles">
        <div class="circle" style="width: 300px; height: 300px; top: -100px; right: -50px;"></div>
        <div class="circle" style="width: 400px; height: 400px; bottom: -150px; left: -100px; animation-duration: 25s;"></div>
    </div>

    <div class="login-container">
        <div class="glass-card">
            <div class="logo-container">
                <img src="{{ asset('panelAdmin/img/LOGOROMBO1.png') }}" alt="Logo">
                <h4 class="text-white mt-3 mb-1">¡Bienvenido!</h4>
                <p class="text-light small">Sistema de Gestión Institucional</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nombre@ejemplo.com">
                    <label for="email">Correo Electrónico</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                    <label for="password">Contraseña</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        Iniciar Sesión <i class="fas fa-sign-in-alt ms-2"></i>
                    </button>
                </div>

                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <div class="text-center mt-4 text-light-50 small">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
