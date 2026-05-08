<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notificación de Nueva Cita</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f5;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            text-align: center;
            padding: 40px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .body-content {
            padding: 40px 30px;
            color: #3f3f46;
            line-height: 1.6;
        }
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #18181b;
            margin-top: 0;
        }
        .details-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        .detail-row {
            margin-bottom: 12px;
            display: flex;
        }
        .detail-label {
            font-weight: 600;
            color: #64748b;
            min-width: 120px;
            display: inline-block;
        }
        .detail-value {
            color: #0f172a;
            font-weight: 500;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Healthify Medical Center</h1>
            <p style="margin-top: 10px; opacity: 0.9;">Nueva Cita Asignada a tu Agenda</p>
        </div>
        
        <div class="body-content">
            <h2 class="greeting">Estimado Dr. {{ $appointment->doctor->user->name }},</h2>
            <p>El sistema automático ha registrado una nueva cita médica en su agenda.</p>
            
            <div class="details-box">
                <div class="detail-row">
                    <span class="detail-label">Paciente:</span>
                    <span class="detail-value">{{ $appointment->patient->user->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Teléfono:</span>
                    <span class="detail-value">{{ $appointment->patient->user->country_code ?? '' }} {{ $appointment->patient->user->phone ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Fecha:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->date)->format('d \d\e F, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Hora:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Motivo:</span>
                    <span class="detail-value">{{ $appointment->reason ?? 'Consulta general' }}</span>
                </div>
            </div>

            <p style="margin-top: 30px;">Adjunto a este correo encontrará el comprobante oficial en formato PDF de esta nueva cita para su expediente.</p>
            
            @if($upcomingAppointments && $upcomingAppointments->count() > 0)
            <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                <h3 style="color: #0f172a; font-size: 16px; margin-bottom: 15px;">Resumen de su Agenda Programada (Próximas Citas)</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background-color: #f1f5f9;">
                            <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e2e8f0; color: #475569;">Fecha</th>
                            <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e2e8f0; color: #475569;">Hora</th>
                            <th style="padding: 10px; text-align: left; border-bottom: 2px solid #e2e8f0; color: #475569;">Paciente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingAppointments as $apt)
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; color: #334155;">{{ \Carbon\Carbon::parse($apt->date)->format('d/m/Y') }}</td>
                            <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; color: #334155;">{{ \Carbon\Carbon::parse($apt->start_time)->format('H:i') }}</td>
                            <td style="padding: 10px; border-bottom: 1px solid #f1f5f9; font-weight: 500; color: #0f172a;">{{ $apt->patient->user->name ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <p style="margin-top: 30px;">Saludos cordiales,<br><strong>Administración de Healthify</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Healthify. Todos los derechos reservados.<br>
            Este es un correo automático del sistema.
        </div>
    </div>
</body>
</html>
