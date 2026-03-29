<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px; }
        .header { text-align: center; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #3b82f6; color: #ffffff !important; text-decoration: none; border-radius: 50px; font-weight: bold; margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 0.85rem; color: #718096; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>IET La Huella</h2>
            <h3>Confirmación de Cambio de Correo</h3>
        </div>
        <p>Hola, <strong>{{ $user->name }}</strong>,</p>
        <p>Hemos recibido una solicitud para cambiar tu dirección de correo electrónico institucional a: <strong>{{ $user->new_email }}</strong>.</p>
        <p>Si realizaste este cambio, por favor confirma tu nueva dirección haciendo clic en el siguiente botón:</p>
        
        <div style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="btn">Confirmar Nuevo Correo</a>
        </div>

        <p>Este enlace de confirmación expirará en 60 minutos.</p>
        <p>Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Institución Educativa Técnica La Huella. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
