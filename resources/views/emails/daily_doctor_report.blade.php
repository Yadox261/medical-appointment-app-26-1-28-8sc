<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tus Citas de Hoy</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
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
            padding: 30px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }
        .body-content {
            padding: 40px 30px;
            color: #3f3f46;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
        }
        tr:hover {
            background-color: #f8fafc;
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
            <p style="margin-top: 5px; opacity: 0.8; font-size: 14px;">Reporte de tus Citas - {{ \Carbon\Carbon::today()->format('d/m/Y') }}</p>
        </div>
        
        <div class="body-content">
            <h2 style="font-size: 18px; color: #0f172a; margin-top: 0;">Hola Dr/Dra. {{ $doctorUser->name }},</h2>
            <p>Este es el resumen de tus citas médicas programadas para el día de hoy:</p>
            
            <table>
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td style="font-weight: bold; color: #059669;">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                        <td style="font-weight: 500;">{{ $appointment->patient->user->name }}</td>
                        <td>{{ $appointment->reason ?? 'Consulta general' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <p style="margin-top: 30px;">Te deseamos un excelente día y una jornada exitosa.</p>
            <p><strong>El equipo de Healthify</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Healthify Medical Center.<br>
            Este es un correo automático del sistema.
        </div>
    </div>
</body>
</html>
