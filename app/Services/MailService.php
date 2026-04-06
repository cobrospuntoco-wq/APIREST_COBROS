<?php

namespace App\Services;

use SendGrid;
use SendGrid\Mail\Mail;

class MailService
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = 'TU_API_KEY_SENDGRID';
    }

    public function enviarCodigo2FA($email, $codigo)
    {
        $emailObj = new Mail();

        $emailObj->setFrom("no-reply@tudominio.com", "CobrosApp");
        $emailObj->setSubject("Código de verificación");
        $emailObj->addTo($email);

        $emailObj->addContent(
            "text/html",
            "<div style='font-family: Arial'>
                <h2>🔐 Código de verificación</h2>
                <p>Tu código es:</p>
                <h1 style='color:#2d89ef;'>$codigo</h1>
                <p>Este código expira en 5 minutos.</p>
            </div>"
        );

        $sendgrid = new SendGrid($this->apiKey);

        try {
            $response = $sendgrid->send($emailObj);

            return $response->statusCode(); // 202 = OK

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}