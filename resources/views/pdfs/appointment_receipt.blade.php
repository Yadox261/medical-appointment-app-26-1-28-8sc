<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante de Cita</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #ffffff;
        }
        .header {
            background-color: #6d28d9;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: normal;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .content {
            padding: 30px 40px;
        }
        .title {
            color: #6d28d9;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        th {
            text-align: left;
            color: #64748b;
            font-weight: bold;
            width: 35%;
        }
        td {
            color: #0f172a;
        }
        .status-confirmed {
            color: #059669;
            font-weight: bold;
        }
        .highlight {
            background-color: #f8fafc;
            padding: 15px;
            border-left: 4px solid #6d28d9;
            margin-top: 30px;
        }
        .highlight p {
            margin: 0;
            font-size: 13px;
            color: #475569;
            line-height: 1.5;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Healthify</h1>
        <p>Tu salud en las mejores manos</p>
    </div>

    <div class="content">
        <div class="title">Comprobante de Cita Médica</div>
        
        <table>
            <tr>
                <th>Paciente:</th>
                <td>{{ $appointment->patient->user->name }}</td>
            </tr>
            <tr>
                <th>Documento de Identidad:</th>
                <td>{{ $appointment->patient->user->id_number ?? 'No registrado' }}</td>
            </tr>
            <tr>
                <th>Doctor Asignado:</th>
                <td>Dr. {{ $appointment->doctor->user->name }}</td>
            </tr>
            <tr>
                <th>Especialidad:</th>
                <td>{{ $appointment->doctor->specialty }}</td>
            </tr>
            <tr>
                <th>Fecha Programada:</th>
                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d \d\e F, Y') }}</td>
            </tr>
            <tr>
                <th>Hora:</th>
                <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</td>
            </tr>
            <tr>
                <th>Motivo de Consulta:</th>
                <td>{{ $appointment->reason ?? 'Consulta General' }}</td>
            </tr>
            <tr>
                <th>Estado:</th>
                <td class="status-confirmed">CONFIRMADA</td>
            </tr>
        </table>

        <div class="highlight">
            <p><strong>Recordatorio Importante:</strong><br>
            Por favor, preséntate en la clínica con 15 minutos de anticipación a tu hora programada. Si necesitas cancelar o reprogramar, comunícate con al menos 24 horas de antelación.</p>
        </div>
    </div>

    <div class="footer">
        <p>Este es un comprobante digital generado automáticamente por Healthify.</p>
        <p>&copy; {{ date('Y') }} Healthify Medical Center. Todos los derechos reservados.</p>
    </div>
</body>
</html>
