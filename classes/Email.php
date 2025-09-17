<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public static function enviarEmail($token) {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP(); // Credenciales  del host
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'c070292837b377';
        $phpmailer->Password = '50b6e654c86c8d';
        $phpmailer->setFrom('from@example.com', 'phpma$phpmailerer'); // De
        $phpmailer->addAddress('allegrosneeze93@gmai.com', 'nombre'); // Para

        $phpmailer->isHTML(true);
        $phpmailer->Subject = 'Subtitulo';
        $phpmailer->Body =  "<a href=\"http://localhost:8080/recovery-password?token={$token}\">Recuperar Contraseña</a>";
        $phpmailer->AltBody = 'Texto alternativo';

        $r = $phpmailer->send(); // Enviar el email
        prec($r);
    }
}