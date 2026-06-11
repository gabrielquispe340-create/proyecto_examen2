<!DOCTYPE html>
<html>
<head>
    <title>Pre-registro Aprobado</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #28a745;">¡Felicidades, tu pre-registro ha sido aprobado!</h2>
        <p>Tu solicitud de pre-registro ha sido revisada y aprobada por el administrador.</p>
        <p>A continuación, te proporcionamos tus credenciales de acceso:</p>
        <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #28a745; margin: 20px 0;">
            <p style="margin: 0;"><strong>Código de Registro:</strong> {{ $codigo }}</p>
            <p style="margin: 0; margin-top: 10px;"><strong>Contraseña:</strong> {{ $password }}</p>
        </div>
        <p>Por favor, guarda esta información en un lugar seguro.</p>
        <p>Atentamente,<br>El equipo de Administración</p>
    </div>
</body>
</html>
