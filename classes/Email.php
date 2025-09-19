<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public static function enviarEmailVerificacion($data) {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP(); // Credenciales  del host
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'dce624e4a90893';
        $phpmailer->Password = '65db5899cf6233';
        $phpmailer->setFrom('accounts@gestordefinanzas.mx', 'GF S.A. de C.V.'); // De
        $phpmailer->addAddress($data->email, $data->nombre); // Para
        
        $phpmailer->CharSet = "UTF-8";
        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'Verifica tu cuenta';
        $phpmailer->Body = "
            <!DOCTYPE html>
            <html lang=\"es\">
            <head>
                <meta charset=\"UTF-8\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <title>Verificación de Cuenta</title>
                <style>
                    /* Estilos generales del cuerpo del email */
                    body {
                        margin: 0;
                        padding: 0;
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        color: #333333;
                    }
                    /* Contenedor principal */
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    }
                    /* Encabezado */
                    .header {
                        text-align: center;
                        padding-bottom: 20px;
                        border-bottom: 1px solid #eeeeee;
                    }
                    .header h1 {
                        margin: 0;
                        font-size: 24px;
                        color: #333333;
                    }
                    /* Contenido principal */
                    .content {
                        padding: 20px 0;
                        line-height: 1.6;
                        text-align: center;
                    }
                    .content p {
                        margin: 0 0 20px;
                    }
                    /* Botón de llamada a la acción */
                    .button {
                        display: inline-block;
                        padding: 12px 25px;
                        background-color: #007bff;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 16px;
                    }
                    /* Pie de página */
                    .footer {
                        padding-top: 20px;
                        border-top: 1px solid #eeeeee;
                        text-align: center;
                        font-size: 12px;
                        color: #888888;
                    }
                    .footer a {
                        color: #007bff;
                        text-decoration: none;
                    }
                </style>
            </head>
            <body>
                <div class=\"container\">
                    <div class=\"header\">
                        <h1>Verifica tu dirección de correo</h1>
                    </div>
                    <div class=\"content\">
                        <p>¡Hola!</p>
                        <p>Gracias por registrarte. Por favor, haz clic en el siguiente botón para verificar tu cuenta y completar tu registro.</p>
                        <a href=\"http://localhost:20000/account-verify?token={$data->token}\" class=\"button\">Verificar Cuenta</a>
                        <p style=\"margin-top: 20px; font-size: 12px; color: #888;\">Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
                        <p style=\"font-size: 12px; color: #888; word-break: break-all;\">http://localhost:20000/account-verify?token={$data->token}</p>
                    </div>
                    <div class=\"footer\">
                        <p>Si no te registraste en nuestro sitio, puedes ignorar este correo electrónico de forma segura.</p>
                        <p>&copy; 2025 Diego Torres Robles. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        $phpmailer->AltBody = "Verifica tu dirección de correo\r¡Hola!\rGracias por registrarte. Para completar tu registro, por favor, copia y pega el siguiente enlace en tu navegador:\rhttp://localhost:20000/account-verify?token={$data->token}\rSi no te registraste en nuestro sitio, puedes ignorar este correo electrónico de forma segura.\r© 2024 Tu Nombre de Empresa. Todos los derechos reservados.";

        $r = $phpmailer->send(); // Enviar el email
        return $r;
    }
}