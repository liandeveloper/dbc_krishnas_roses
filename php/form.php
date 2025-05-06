<?php
// Agrega esto al inicio de tu PHP
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

// Validar que sea una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener datos del formulario
$data = [
    'product_name' => $_POST['product_name'] ?? 'Desconocido',
    'product_description' => $_POST['product_description'] ?? '',
    'product_color' => $_POST['product_color'] ?? '',
    'product_size' => $_POST['product_size'] ?? '',
    'product_price' => $_POST['product_price'] ?? '',
    'customer_name' => $_POST['customer_name'] ?? '',
    'customer_email' => filter_var($_POST['customer_email'] ?? '', FILTER_VALIDATE_EMAIL),
    'payment_method' => $_POST['payment_method'] ?? '',
    'shipping_address' => $_POST['shipping_address'] ?? ''
];

// Validar campos obligatorios
if (empty($data['customer_name']) || empty($data['customer_email']) || 
    empty($data['payment_method']) || empty($data['shipping_address'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
    exit;
}

// Construir el mensaje de correo
$message = "
<h2>Detalles del Producto</h2>
<p><strong>Producto:</strong> {$data['product_name']}</p>
<p><strong>Descripción:</strong> {$data['product_description']}</p>
<p><strong>Color:</strong> {$data['product_color']}</p>
<p><strong>Tamaño:</strong> {$data['product_size']}</p>
<p><strong>Precio:</strong> {$data['product_price']}</p>

<h2>Información del Cliente</h2>
<p><strong>Nombre:</strong> {$data['customer_name']}</p>
<p><strong>Email:</strong> {$data['customer_email']}</p>
<p><strong>Método de Pago:</strong> {$data['payment_method']}</p>
<p><strong>Dirección:</strong> {$data['shipping_address']}</p>
";

$to = 'liandev@proton.me';  // Cambiar por tu correo real
$subject = "Nueva compra: {$data['product_name']}";
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: webmaster@tudominio.com\r\n";
$headers .= "Reply-To: {$data['customer_email']}\r\n";

// Intentar enviar el correo
try {
    $mailSent = mail($to, $subject, $message, $headers);
    
    if ($mailSent) {
        echo json_encode([
            'success' => true,
            'message' => '¡Compra realizada! Recibirás un correo de confirmación.'
        ]);
    } else {
        throw new Exception('El servidor no pudo enviar el correo');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al enviar el correo: ' . $e->getMessage()
    ]);
}
?>