<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Credenciales de Acceso</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #1a56db; text-align: center; margin-bottom: 20px;">Tus Credenciales de Acceso - CUP FICCT</h2>
        <p style="color: #333; font-size: 16px; line-height: 1.5;">Hola,</p>
        <p style="color: #333; font-size: 16px; line-height: 1.5;">Tu registro ha sido procesado exitosamente. A continuación, te proporcionamos tus credenciales temporales para acceder al sistema:</p>
        
        <div style="background-color: #f8fafc; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #1a56db;">
            <p style="margin: 0 0 10px 0; font-size: 16px;"><strong>Código de Registro / Usuario:</strong> {{ $codigo_registro }}</p>
            <p style="margin: 0; font-size: 16px;"><strong>Contraseña Temporal:</strong> {{ $contrasena_correo }}</p>
        </div>

        <p style="color: #333; font-size: 16px; line-height: 1.5;">Te recomendamos cambiar esta contraseña una vez ingreses al sistema por primera vez por motivos de seguridad.</p>

        <p style="color: #333; font-size: 16px; line-height: 1.5;">Saludos cordiales,<br><strong>Equipo CUP - FICCT</strong></p>
    </div>
</body>
</html>
