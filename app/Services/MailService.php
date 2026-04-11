<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    public static function send($to, $nombre = "",$codigoFactor)
    {
        $mail = new PHPMailer(true);
        $subject = 'Código de Verificación de Acceso';
        $html= " <html>
                <body style='background:#f4f6f8; font-family:Arial;'>
                    <div style='max-width:600px;margin:auto;background:#fff;padding:20px;border-radius:8px;'>
                        <h2 style='background:#0d6efd;color:#fff;padding:15px;text-align:center;'>
                            🔐 Para acceder a tu cuenta
                        </h2>
                        <p>Hola <strong>{$nombre}</strong>,</p>
                        <p>Tu código de verificación es:</p>
                        <div style='text-align:center;margin:30px 0;'>
                            <span style='font-size:30px;font-weight:bold;color:#0d6efd;'>
                                {$codigoFactor}
                            </span>
                        </div>
                        <p>Este código expira en 5 minutos.</p>
                        <p>Si no solicitaste esto, ignora este mensaje.</p>
                    </div>
                </body>
                </html>";
        try {
            // 🔧 CONFIGURACIÓN SMTP (Plesk)
            $mail->isSMTP();
            $mail->Host       = 'mail.cobrosapp.pro'; // o localhost
            $mail->SMTPAuth   = true;
            $mail->Username   = 'smtp@cobrosapp.pro';
            $mail->Password   = 'w1d8F4~2a';
            $mail->SMTPSecure = 'tls';
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // 👤 REMITENTE Y DESTINO
            $mail->setFrom('smtp@cobrosapp.pro', 'CemSys');
            $mail->addAddress($to, $nombre);

            // 📧 CONTENIDO
            $mail->isHTML(true);
            $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true
                    ]
                ];
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->AltBody = strip_tags($html);

            // 🚀 ENVÍO
            $mail->send();

            return true;

        } catch (\Exception $e) {
            error_log("Error correo: " . $mail->ErrorInfo);
            return  $e->getMessage();
        }
    }
}