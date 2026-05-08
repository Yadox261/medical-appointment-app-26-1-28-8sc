<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sin Citas Programadas Hoy</title>
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
            background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
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
            text-align: center;
        }
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #18181b;
            margin-top: 0;
        }
        .icon {
            font-size: 48px;
            margin: 20px 0;
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
            <p style="margin-top: 10px; opacity: 0.9;">Reporte Diario de Agenda</p>
        </div>
        
        <div class="body-content">
            <h2 class="greeting">Buen día, Dr. {{ $doctorUser->name }}</h2>
            
            <div class="icon">☕</div>
            
            <p>Le informamos que el día de hoy, <strong>{{ \Carbon\Carbon::today()->format('d \d\e F, Y') }}</strong>, no tiene ninguna cita programada en su agenda.</p>
            
            <p style="margin-top: 30px; color: #64748b; font-size: 15px;">Aproveche este tiempo para realizar actividades administrativas o disfrutar de un descanso merecido.</p>
            
            <p style="margin-top: 40px;">Saludos cordiales,<br><strong>Administración de Healthify</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Healthify. Todos los derechos reservados.<br>
            Este es un correo automático del sistema.
        </div>
    </div>
</body>
</html>
