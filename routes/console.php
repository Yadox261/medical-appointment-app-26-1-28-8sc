<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Enviar reporte diario de citas a las 14:35 PM (Para pruebas / entrega)
Schedule::command('app:send-daily-reports')->dailyAt('14:35');

// Enviar recordatorios de WhatsApp para las citas de mañana (ej. a las 14:35 PM)
Schedule::command('app:send-appointment-reminders')->dailyAt('14:35');
