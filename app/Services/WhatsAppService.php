<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp message.
     * 
     * @param string $phone The recipient's phone number.
     * @param string $message The message text.
     * @return bool
     */
    public function sendMessage($phone, $message)
    {
        if (empty($phone)) {
            Log::warning('WhatsAppService: Intento de enviar mensaje a un número vacío.');
            return false;
        }

        // 1. Limpiar el número de espacios, guiones o paréntesis
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        // 2. Si el número no empieza con '+', le agregamos el código de país por defecto (Ej: +52 para México)
        if (!str_starts_with($phone, '+')) {
            $codigoPais = '+52'; // Puedes cambiar esto al código de tu país
            $phone = $codigoPais . $phone;
        }

        // Conexión real a la API de UltraMsg
        $token = 'll2o57w2pmkle9td';
        $instance = 'instance174035';
        $url = "https://api.ultramsg.com/{$instance}/messages/chat";

        try {
            $response = Http::withoutVerifying()->asForm()->post($url, [
                'token' => $token,
                'to'    => $phone,
                'body'  => $message
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp enviado exitosamente a {$phone}");
                return true;
            } else {
                Log::error("Error al enviar WhatsApp a {$phone}: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Excepción al intentar enviar WhatsApp: " . $e->getMessage());
            return false;
        }
    }
}
