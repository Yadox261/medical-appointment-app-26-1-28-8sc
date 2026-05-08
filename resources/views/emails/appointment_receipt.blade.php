<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Cita Médica</title>
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
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
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
        .attachment-notice {
            background-color: #eff6ff;
            color: #1d4ed8;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
            margin-top: 20px;
            font-size: 14px;
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
            <p style="margin-top: 10px; opacity: 0.9;">Confirmación de Cita Programada</p>
        </div>
        
        <div class="body-content">
            <h2 class="greeting">Hola, {{ $appointment->patient->user->name }}</h2>
            <p>Nos complace informarte que tu cita médica ha sido agendada y confirmada exitosamente en nuestro sistema.</p>
            
            <div class="details-box">
                <div class="detail-row">
                    <span class="detail-label">Doctor:</span>
                    <span class="detail-value">Dr. {{ $appointment->doctor->user->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Especialidad:</span>
                    <span class="detail-value">{{ $appointment->doctor->specialty }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Fecha:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->date)->format('d \d\e F, Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Hora:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</span>
                </div>
            </div>

            <div class="attachment-notice">
                📄 <strong>Archivo Adjunto:</strong> Hemos adjuntado un documento PDF con todos los detalles de tu cita. Por favor, descárgalo o guárdalo como comprobante.
            </div>

            <p style="margin-top: 30px;">Si tienes alguna duda o necesitas reprogramar, no dudes en contactarnos.</p>
            
            <p>Saludos cordiales,<br><strong>El equipo de Healthify</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Healthify. Todos los derechos reservados.<br>
            Este es un correo automático, por favor no respondas a esta dirección.
        </div>
    </div>
</body>
</html>
