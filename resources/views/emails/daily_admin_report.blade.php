<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte General de Citas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 700px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
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
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-scheduled { background-color: #dbeafe; color: #1d4ed8; }
        .status-completed { background-color: #dcfce3; color: #15803d; }
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
            <h1>Panel Administrativo Healthify</h1>
            <p style="margin-top: 5px; opacity: 0.8; font-size: 14px;">Reporte General de Citas - {{ \Carbon\Carbon::today()->format('d/m/Y') }}</p>
        </div>
        
        <div class="body-content">
            <p>A continuación se detallan todas las citas médicas programadas para la clínica el día de hoy:</p>
            
            <table>
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Doctor</th>
                        <th>Paciente</th>
                        <th>Especialidad</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                    <tr>
                        <td><strong>{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</strong></td>
                        <td>Dr. {{ $appointment->doctor->user->name }}</td>
                        <td>{{ $appointment->patient->user->name }}</td>
                        <td>{{ $appointment->doctor->specialty }}</td>
                        <td>
                            @if($appointment->status == 1)
                                <span class="status-badge status-scheduled">Programada</span>
                            @else
                                <span class="status-badge status-completed">Completada</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <p style="margin-top: 30px;">Este reporte es generado automáticamente por el sistema central.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Healthify Medical Center.<br>
            Uso exclusivo interno.
        </div>
    </div>
</body>
</html>
