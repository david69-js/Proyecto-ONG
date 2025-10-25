<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    /**
     * Mostrar el formulario de contacto
     */
    public function index()
    {
        return view('contact.index');
    }

    public function index2()
{
    return view('contact.index2'); // vista dorada
}

    /**
     * Enviar el mensaje de contacto por email
     */
    public function send(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'phone' => 'nullable|string|max:20'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'subject.required' => 'El asunto es obligatorio.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.max' => 'El mensaje no puede exceder los 2000 caracteres.',
            'phone.max' => 'El teléfono no puede exceder los 20 caracteres.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Guardar mensaje en la base de datos primero
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Datos para el email
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'phone' => $request->phone ?? 'No proporcionado',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'timestamp' => now()->format('d/m/Y H:i:s')
            ];

            // Intentar enviar email usando PHPMailer directamente
            try {
                // Crear el mensaje HTML
                $htmlMessage = "
                <html>
                <head>
                    <title>Nuevo Mensaje de Contacto - Habitat Guatemala</title>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                        .header { background: #007bff; color: white; padding: 20px; text-align: center; }
                        .content { padding: 20px; background: #f8f9fa; }
                        .field { margin: 10px 0; padding: 10px; background: white; border-left: 4px solid #007bff; }
                        .field-label { font-weight: bold; color: #007bff; }
                    </style>
                </head>
                <body>
                    <div class='header'>
                        <h1>🏠 Habitat Guatemala</h1>
                        <h2>Nuevo Mensaje de Contacto</h2>
                    </div>
                    <div class='content'>
                        <div class='field'>
                            <div class='field-label'>👤 Nombre:</div>
                            <div>" . htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8') . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>📧 Email:</div>
                            <div>" . htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8') . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>📞 Teléfono:</div>
                            <div>" . htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8') . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>🏷️ Asunto:</div>
                            <div>" . htmlspecialchars($data['subject'], ENT_QUOTES, 'UTF-8') . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>💬 Mensaje:</div>
                            <div>" . nl2br(htmlspecialchars($data['message'], ENT_QUOTES, 'UTF-8')) . "</div>
                        </div>
                        <div class='field'>
                            <div class='field-label'>📅 Fecha:</div>
                            <div>" . $data['timestamp'] . "</div>
                        </div>
                        <hr>
                        <p><strong>Información Técnica:</strong><br>
                        IP: " . htmlspecialchars($data['ip'], ENT_QUOTES, 'UTF-8') . "<br>
                        User Agent: " . htmlspecialchars($data['user_agent'], ENT_QUOTES, 'UTF-8') . "</p>
                    </div>
                </body>
                </html>
                ";

                // Configurar PHPMailer
                $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
                
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jeffersonperezblanco22@gmail.com';
                $mail->Password = 'auvp gjoy otns jeen';
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';

                // Remitentes y destinatarios
                $mail->setFrom('jeffersonperezblanco22@gmail.com', 'Habitat Guatemala');
                $mail->addAddress('jeffersonperezblanco22@gmail.com');
                $mail->addReplyTo($data['email'], $data['name']);

                // Contenido
                $mail->isHTML(true);
                $mail->Subject = 'Nuevo mensaje de contacto: ' . $data['subject'];
                $mail->Body = $htmlMessage;

                // Enviar
                $mail->send();
                \Log::info('Mensaje de contacto enviado por PHPMailer:', $data);

            } catch (\Exception $emailError) {
                \Log::error('Error al enviar email con PHPMailer: ' . $emailError->getMessage());
                
                // Intentar con mail() nativo como último recurso
                try {
                    $to = 'jeffersonperezblanco22@gmail.com';
                    $subject = 'Nuevo mensaje de contacto: ' . $data['subject'];
                    
                    $simpleMessage = "
                    NUEVO MENSAJE DE CONTACTO - HABITAT GUATEMALA
                    
                    Nombre: " . $data['name'] . "
                    Email: " . $data['email'] . "
                    Teléfono: " . $data['phone'] . "
                    Asunto: " . $data['subject'] . "
                    
                    Mensaje:
                    " . $data['message'] . "
                    
                    Fecha: " . $data['timestamp'] . "
                    IP: " . $data['ip'] . "
                    ";
                    
                    $headers = "From: Habitat Guatemala <noreply@habitatguatemala.org>\r\n";
                    $headers .= "Reply-To: " . $data['email'] . "\r\n";
                    
                    if (mail($to, $subject, $simpleMessage, $headers)) {
                        \Log::info('Mensaje enviado por mail() nativo como respaldo');
                    } else {
                        \Log::warning('Error en todos los métodos de envío, pero mensaje guardado en BD');
                    }
                } catch (\Exception $backupError) {
                    \Log::warning('Error en método de respaldo: ' . $backupError->getMessage());
                }
            }

            return redirect()->back()->with('success', '¡Mensaje enviado correctamente! Te contactaremos pronto.');

        } catch (\Exception $e) {
            // Log del error para debugging
            \Log::error('Error al procesar mensaje de contacto: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.')
                ->withInput();
        }
    }
}