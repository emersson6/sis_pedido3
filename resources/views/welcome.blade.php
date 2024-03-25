<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión en el sistema</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: url('https://www.ventisquero.com/img/nosotros/historia.jpg') no-repeat center center;
            background-size: cover;
            overflow: hidden;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6); /* Capa translúcida */
            z-index: 1;
        }

        .modal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.2); /* Fondo translúcido blanco */
            backdrop-filter: blur(10px); /* Efecto de vidrio */
            padding: 40px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        input[type="email"],
        input[type="password"],
        .login-button {
            width: 100%;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.5); /* Fondo claro para los campos de entrada */
            color: black;
            box-sizing: border-box; /* Asegurar que el relleno no afecte el ancho */
        }

        label {
            margin-bottom: 10px; /* Aumentado el margen inferior */
            color: white;
            font-size: 16px; /* Aumentado el tamaño de fuente */
            display: block; /* Hacer que los labels sean bloques para que ocupen todo el ancho */
        }

        .login-button {
            background-color: #6c63ff;
            color: white;
            cursor: pointer;
            font-size: 18px; /* Aumentado el tamaño de fuente */
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #5751d9;
        }

        .text-gray-600 {
            color: #888888;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="modal">
        <!-- Estado de sesión -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Correo electrónico -->
            <div>
                <label for="email">Correo electrónico</label>
                <input id="email" class="block mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password">Contraseña</label>

                <input id="password" class="block mt-1"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Recordarme -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div>

            <div class="flex items-center justify-center mt-4">
                <button class="login-button">Iniciar sesión</button>
            </div>
        </form>
    </div>
</body>
</html>
