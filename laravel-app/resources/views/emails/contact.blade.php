<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuevo Mensaje de Contacto - Habitat Guatemala</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        .field-label {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        .field-value {
            color: #333;
        }
        .message-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding: 20px;
            background: #e9ecef;
            border-radius: 8px;
            font-size: 12px;
            color: #666;
        }
        .highlight {
            background: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏠 Habitat Guatemala</h1>
        <h2>Nuevo Mensaje de Contacto</h2>
    </div>
    
    <div class="content">
        <div class="highlight">
            <strong>📧 Nuevo mensaje recibido desde el sitio web</strong><br>
            <small>Fecha: {!! htmlspecialchars($timestamp, ENT_QUOTES, 'UTF-8') !!}</small>
        </div>
        
        <div class="field">
            <div class="field-label">👤 Nombre:</div>
            <div class="field-value">{!! htmlspecialchars($name, ENT_QUOTES, 'UTF-8') !!}</div>
        </div>
        
        <div class="field">
            <div class="field-label">📧 Email:</div>
            <div class="field-value">{!! htmlspecialchars($email, ENT_QUOTES, 'UTF-8') !!}</div>
        </div>
        
        <div class="field">
            <div class="field-label">📞 Teléfono:</div>
            <div class="field-value">{!! htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') !!}</div>
        </div>
        
        <div class="field">
            <div class="field-label">🏷️ Asunto:</div>
            <div class="field-value">{!! htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') !!}</div>
        </div>
        
        <div class="message-box">
            <div class="field-label">💬 Mensaje:</div>
            <div class="field-value" style="white-space: pre-wrap;">{!! nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) !!}</div>
        </div>
        
        <div class="footer">
            <strong>Información Técnica:</strong><br>
            IP: {!! htmlspecialchars($ip, ENT_QUOTES, 'UTF-8') !!}<br>
            User Agent: {!! htmlspecialchars($user_agent, ENT_QUOTES, 'UTF-8') !!}<br>
            <br>
            <em>Este mensaje fue enviado automáticamente desde el formulario de contacto del sitio web de Habitat Guatemala.</em>
        </div>
    </div>
</body>
</html>
