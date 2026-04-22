<?php
include './includes/conexion.php';
require_once '../vendor/autoload.php';
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$cines = mysqli_query($conn, "SELECT * FROM cines");

// Configuración básica
$page_title = "Dream Movie - Comprar Entradas";
$current_page = "comprar";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="./assets/css/pasosCompra.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="./assets/css/StylesIndex.css" rel="stylesheet">
    <link href="./assets/css/comprar.css" rel="stylesheet">
    <link rel="icon" href="./assets/icons/icon.png" type="image/png">
</head>
<body>
    <!-- Header -->
    <?php include './includes/header.php'; ?>

    <!-- Navigation -->
    <?php include './includes/nav.php'; ?>

    <!-- Pasos de compra -->
    <div class="compra-pasos">
        <div class="linea-pasos"><div class="linea-activa" id="lineaActiva"></div></div>
        <div class="paso paso1 active" data-step="1" data-aos="fade-up" data-aos-delay="100"><div class="paso-numero">1</div><div class="paso-texto">Cine y Fecha</div></div>
        <div class="paso paso2" data-step="2" data-aos="fade-up" data-aos-delay="200"><div class="paso-numero">2</div><div class="paso-texto">Película</div></div>
        <div class="paso paso3" data-step="3" data-aos="fade-up" data-aos-delay="300"><div class="paso-numero">3</div><div class="paso-texto">Sala y Hora</div></div>
        <div class="paso paso4" data-step="4" data-aos="fade-up" data-aos-delay="400"><div class="paso-numero">4</div><div class="paso-texto">Entradas</div></div>
        <div class="paso paso5" data-step="5" data-aos="fade-up" data-aos-delay="500"><div class="paso-numero">5</div><div class="paso-texto">Butacas</div></div>
        <div class="paso paso6" data-step="6" data-aos="fade-up" data-aos-delay="600"><div class="paso-numero">6</div><div class="paso-texto">Pago</div></div>
    </div>

    <div class="compra-card card">
        <div class="card-header">
            <h2 class="card-title">Comprar Entradas</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="comprar.php" id="formCompra">
                <!-- Campo oculto para los asientos seleccionados -->
                <input type="hidden" name="asientos" id="asientosSeleccionados" value="">
                <!-- Campo oculto para el total calculado con JS (con descuentos) -->
                <input type="hidden" name="total_final" id="totalFinal" value="">
                
                <!-- Paso 1: Cine y Fecha -->
                <div id="step1">
                    <div class="row mb-3">
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                            <label for="cine" class="form-label" style="color: #fff;">Cine:</label>
                            <select name="cine" id="cine" class="form-select" required>
                                <option value="">Seleccione un cine</option>
                                <?php while($cine = mysqli_fetch_assoc($cines)): ?>
                                    <option value="<?= $cine['id'] ?>"><?= $cine['nombre'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="800">
                            <label for="dia" class="form-label" style="color: #fff;">Día:</label>
                            <select name="dia" id="dia" class="form-select" required>
                                <option value="">Seleccione un día</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" id="next1" class="btn btn-primary">Siguiente</button>
                    </div>
                </div>

                <!-- Paso 2: Película -->
                <div id="step2" style="display:none;">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="pelicula" class="form-label" style="color: #fff;">Película:</label>
                            <select name="pelicula" id="pelicula" class="form-select" required>
                                <option value="">Seleccione una película</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" id="prev2" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="next2" class="btn btn-primary">Siguiente</button>
                    </div>
                </div>

                <!-- Paso 3: Sala y Hora -->
                <div id="step3" style="display:none;">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sala" class="form-label" style="color: #fff;">Sala:</label>
                            <select name="sala" id="sala" class="form-select" required>
                                <option value="">Seleccione una sala</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="hora" class="form-label" style="color: #fff;">Hora:</label>
                            <select name="hora" id="hora" class="form-select" required>
                                <option value="">Seleccione una hora</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" id="prev3" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="next3" class="btn btn-primary">Siguiente</button>
                    </div>
                </div>

                <!-- Paso 4: Entradas -->
                <div id="step4" style="display:none;">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label" style="color: #fff;">Adulto (₡3500):</label>
                            <input type="number" name="adulto" id="adulto" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="color: #fff;">Niño (₡2000):</label>
                            <input type="number" name="nino" id="nino" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="color: #fff;">Adulto Mayor (₡2500):</label>
                            <input type="number" name="mayor" id="mayor" class="form-control" min="0" value="0">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" id="prev4" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="next4" class="btn btn-primary">Siguiente</button>
                    </div>
                </div>

                <!-- Paso 5: Selección de butacas -->
                <div class="sala-container mb-3" id="step5" style="display:none;">
                    <div class="pantalla">Pantalla</div>
                    <div id="butacas" class="asientos-grid"></div>
                    <div class="leyenda-asientos mt-3">
                        <div class="leyenda-item"><span class="asiento disponible"></span> Disponible</div>
                        <div class="leyenda-item"><span class="asiento seleccionado"></span> Seleccionado</div>
                        <div class="leyenda-item"><span class="asiento ocupado"></span> Ocupado</div>
                        <div class="leyenda-item"><span class="asiento discapacitado"></span> Discapacitado</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" id="prev5" class="btn btn-secondary">Anterior</button>
                        <button type="button" id="next5" class="btn btn-primary">Siguiente</button>
                    </div>
                </div>

                <!-- Paso 6: Resumen y pago -->
                <div id="step6" style="display:none;">
                    <div class="pago-resumen-layout">
                        <div class="pago-formulario">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label" style="color: #fff;">Nombre:</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" style="color: #fff;">Correo:</label>
                                    <input type="email" name="correo" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" style="color: #fff;">Tarjeta:</label>
                                    <input type="text" name="tarjeta" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #fff;">Fecha de vencimiento:</label>
                                    <input type="month" name="fecha_vencimiento" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="color: #fff;">CVV:</label>
                                    <input type="text" name="cvv" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" style="color: #fff;">Código promocional:</label>
                                <div class="input-group">
                                    <input type="text" name="codigo_promocional" id="codigo_promocional" class="form-control" placeholder="Ingresa tu código">
                                    <button type="button" class="btn btn-info" id="aplicarCodigo">Aplicar código</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" id="prev6" class="btn btn-secondary">Anterior</button>
                                <button type="submit" name="comprar" class="btn btn-success">Pagar</button>
                            </div>
                        </div>
                        <aside class="resumen-aside">
                            <div class="resumen-header"><i class="bi bi-ticket-perforated"></i><h4>Resumen de compra</h4></div>
                            <div class="resumen-body" id="resumen-body"></div>
                        </aside>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Social Media Section -->
    <?php include './includes/redes.php'; ?>

    <!-- Footer -->
    <?php include './includes/footer.php'; ?>

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-seat-charts/1.1.5/jquery.seat-charts.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-seat-charts/1.1.5/jquery.seat-charts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/script.js"></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset: 100,
            once: true
        });
    </script>

    <?php
    // LÓGICA DE PROCESAMIENTO DE COMPRA
    if (isset($_POST['comprar'])) {
        // Validación de datos recibidos
        $cine_id = isset($_POST['cine']) ? intval($_POST['cine']) : 0;
        $dia = isset($_POST['dia']) ? mysqli_real_escape_string($conn, $_POST['dia']) : '';
        $pelicula_id = isset($_POST['pelicula']) ? intval($_POST['pelicula']) : 0;
        $sala_id = isset($_POST['sala']) ? intval($_POST['sala']) : 0;
        $hora = isset($_POST['hora']) ? mysqli_real_escape_string($conn, $_POST['hora']) : '';
        $adulto = isset($_POST['adulto']) ? max(0, intval($_POST['adulto'])) : 0;
        $nino = isset($_POST['nino']) ? max(0, intval($_POST['nino'])) : 0;
        $mayor = isset($_POST['mayor']) ? max(0, intval($_POST['mayor'])) : 0;
        $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($conn, $_POST['nombre']) : '';
        $correo = isset($_POST['correo']) ? mysqli_real_escape_string($conn, $_POST['correo']) : '';
        $tarjeta = isset($_POST['tarjeta']) ? mysqli_real_escape_string($conn, $_POST['tarjeta']) : '';
        $fecha_compra = date('Y-m-d H:i:s');
        $asientos = isset($_POST['asientos']) ? explode(',', $_POST['asientos']) : [];
        $codigo_promocional = isset($_POST['codigo_promocional']) ? mysqli_real_escape_string($conn, $_POST['codigo_promocional']) : '';
        
        // Limpiar espacios de los asientos
        $asientos = array_map('trim', $asientos);
        $asientos = array_filter($asientos); // Eliminar elementos vacíos
        
        // Calcular total 
        $total = isset($_POST['total_final']) && !empty($_POST['total_final']) 
                ? floatval($_POST['total_final']) 
                : ($adulto * 3500) + ($nino * 2000) + ($mayor * 2500) + 350;
        $total_entradas = $adulto + $nino + $mayor;
        
        // Validaciones
        if ($total_entradas == 0) {
            echo '<script>Swal.fire("Error", "Debe seleccionar al menos una entrada", "error");</script>';
        } elseif (count($asientos) != $total_entradas) {
            echo '<script>Swal.fire("Error", "Debe seleccionar exactamente ' . $total_entradas . ' asientos", "error");</script>';
        } elseif (empty($nombre) || empty($correo) || empty($tarjeta)) {
            echo '<script>Swal.fire("Error", "Todos los campos son obligatorios", "error");</script>';
        } else {
            // Obtener datos adicionales
            $cine_query = mysqli_query($conn, "SELECT nombre FROM cines WHERE id = $cine_id");
            $cine_data = mysqli_fetch_assoc($cine_query);
            $cine_nombre = $cine_data['nombre'];
            
            $pelicula_query = mysqli_query($conn, "SELECT titulo FROM peliculas WHERE id = $pelicula_id");
            $pelicula_data = mysqli_fetch_assoc($pelicula_query);
            $pelicula_titulo = $pelicula_data['titulo'];
            
            // Buscar la función
            $funcion = mysqli_query($conn, "SELECT id FROM funciones WHERE id_sala='$sala_id' AND id_pelicula='$pelicula_id' AND fecha='$dia' AND hora='$hora'");
            if (mysqli_num_rows($funcion) > 0) {
                $row = mysqli_fetch_assoc($funcion);
                $id_funcion = $row['id'];

                // Crear arreglo de tipos y precios
                $tipos = array_merge(
                    array_fill(0, $adulto, ['tipo' => 'adulto', 'precio' => 3500]),
                    array_fill(0, $nino, ['tipo' => 'nino', 'precio' => 2000]),
                    array_fill(0, $mayor, ['tipo' => 'mayor', 'precio' => 2500])
                );

                // Insertar cada entrada con su asiento
                $insert_success = true;
                foreach ($asientos as $i => $asiento) {
                    if (isset($tipos[$i])) {
                        $tipo = $tipos[$i]['tipo'];
                        $precio = $tipos[$i]['precio'];
                        $query = "INSERT INTO entradas (id_funcion, tipo, precio, asiento, nombre_cliente, correo_cliente, tarjeta_cliente, fecha_compra)
                                VALUES ('$id_funcion', '$tipo', '$precio', '$asiento', '$nombre', '$correo', '$tarjeta', '$fecha_compra')";
                        if (!mysqli_query($conn, $query)) {
                            $insert_success = false;
                            break;
                        }
                    }
                }
                
                if ($insert_success) {
                    // Llamar a la función nueva de correo con QR embebido
                    enviarCorreoConQR($nombre, $correo, $tarjeta, $cine_nombre, $dia, $pelicula_titulo, $sala_id, $hora, $adulto, $nino, $mayor, implode(', ', $asientos), $total, $codigo_promocional);
                    echo '<script>
                        // Mostrar loading durante el proceso
                        Swal.fire({
                            title: "Procesando compra...",
                            html: "Enviando entrada por correo <br><div class=\"progress\" style=\"margin-top: 20px;\"><div class=\"progress-bar progress-bar-striped progress-bar-animated\" role=\"progressbar\" style=\"width: 100%; background: linear-gradient(45deg, #007bff, #0056b3);\"></div></div>",
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Simular progreso y luego mostrar éxito
                        setTimeout(() => {
                            Swal.fire({
                                icon: "success",
                                title: "¡Compra exitosa!",
                                html: `
                                    <div style="text-align: center;">
                                        <div style="font-size: 18px; margin-bottom: 15px;">
                                            <i class="bi bi-check-circle-fill" style="color: #28a745; font-size: 48px;"></i>
                                        </div>
                                        <p><strong>Tu entrada ha sido enviada por correo</strong></p>
                                        <p style="color: #6c757d; font-size: 14px;">
                                            📧 Revisa tu bandeja de entrada<br>
                                            📱 Presenta el QR en el cine
                                        </p>
                                    </div>
                                `,
                                confirmButtonText: "Ir al inicio",
                                confirmButtonColor: "#007bff",
                                allowOutsideClick: false
                            }).then(() => {
                                window.location.href = "index.php";
                            });
                        }, 2000);
                    </script>';
                } else {
                    echo '<script>Swal.fire("Error", "Error al procesar la compra", "error");</script>';
                }
            } else {
                echo '<script>Swal.fire("Error", "Función no encontrada", "error");</script>';
            }
        }
    }
    
    // FUNCIÓN CORREGIDA PARA ENVIAR CORREO CON QR EMBEBIDO
function enviarCorreoConQR($nombre, $correo, $tarjeta, $cine, $dia, $pelicula, $sala, $hora, $adulto, $nino, $mayor, $butacas, $total, $codigo_promocional = '') {
    // Generar número de ticket único
    $ticketNumber = 'DM-' . date('YmdHis') . '-' . rand(100, 999);

    // Generar QR como archivo temporal y luego convertir a base64
    $qrData = "Ticket: $ticketNumber\nCine: $cine\nFecha: $dia\nPelicula: $pelicula\nSala: $sala\nHora: $hora\nEntradas: A:$adulto N:$nino M:$mayor\nButacas: $butacas\nTotal: ₡$total";

    $options = new QROptions([
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel' => QRCode::ECC_L,
        'scale' => 8,  // Aumentar el tamaño
        'imageBase64' => false,  // Generar como archivo primero
    ]);

    $qr = new QRCode($options);
    
    // Generar el QR como string de imagen PNG
    $qrImage = $qr->render($qrData);
    
    // Convertir a base64 manualmente
    $qrImageBase64 = base64_encode($qrImage);

    // ENVIAR CORREO
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = ''; // correo
        $mail->Password = ''; // clave de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('', 'Dream Movie');
        $mail->addAddress($correo, $nombre);
        $mail->Subject = '🎬 Tu entrada para ' . $pelicula . ' - Dream Movie';
        
        // MÉTODO ALTERNATIVO: Adjuntar el QR como archivo embebido
        // Crear archivo temporal para el QR
        $tempQRFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
        file_put_contents($tempQRFile, $qrImage);
        
        // Adjuntar el archivo QR con un CID (Content-ID)
        $mail->addEmbeddedImage($tempQRFile, 'qr_code', 'qr_code.png', 'base64', 'image/png');
        
        // Calcular detalles de entradas
        $detalleEntradas = [];
        if ($adulto > 0) $detalleEntradas[] = $adulto . ' x Entrada de Adulto ₡' . number_format($adulto * 3500, 0);
        if ($nino > 0) $detalleEntradas[] = $nino . ' x Entrada de Niño ₡' . number_format($nino * 2000, 0);
        if ($mayor > 0) $detalleEntradas[] = $mayor . ' x Entrada de Adulto Mayor ₡' . number_format($mayor * 2500, 0);
        if (!empty($codigo_promocional)) {
            $detalleEntradas[] = 'Descuento ' . $codigo_promocional . ' ₡-3,500';
        }
        $detalleEntradas[] = 'Tarifa de Servicio ₡350';
        
        $detalleEntradasHTML = '';
        foreach ($detalleEntradas as $detalle) {
            $esDescuento = strpos($detalle, '₡-') !== false;
            $color = $esDescuento ? 'color: #dc2626; font-weight: bold;' : '';
            $partes = explode(' ₡', $detalle);
            $detalleEntradasHTML .= '<div style="padding: 8px 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; ' . $color . '">
                <span>' . $partes[0] . '</span>
                <span style="font-weight: bold;">₡' . $partes[1] . '</span>
            </div>';
        }
        
        // Formatear fecha más legible
        $fechaFormateada = date('d/m/Y', strtotime($dia));
        
        $mailBody = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");
                body { font-family: "Inter", Arial, sans-serif; margin: 0; padding: 0; background-color: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; background-color: #fff; }
                .header { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); color: white; padding: 30px 40px; text-align: center; position: relative; overflow: hidden; }
                .header::before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url("data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat; opacity: 0.1; }
                .logo { font-size: 28px; font-weight: 700; margin-bottom: 5px; z-index: 1; position: relative; }
                .tagline { font-size: 14px; opacity: 0.9; margin: 0; z-index: 1; position: relative; }
                .ticket-section { background: #fff; padding: 0; position: relative; }
                .greeting { padding: 30px 40px 20px; background: linear-gradient(to right, #667eea 0%, #764ba2 100%); color: white; text-align: center; }
                .greeting h2 { margin: 0 0 10px 0; font-size: 24px; font-weight: 600; }
                .greeting p { margin: 0; opacity: 0.9; font-size: 16px; }
                .qr-section { background: #f8fafc; padding: 40px; text-align: center; border-top: 3px solid #667eea; }
                .qr-title { font-size: 18px; font-weight: 600; color: #1e293b; margin-bottom: 15px; }
                .qr-subtitle { color: #64748b; margin-bottom: 25px; font-size: 14px; }
                .qr-container { background: white; display: inline-block; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-bottom: 20px; }
                .qr-image { width: 200px; height: 200px; border: 2px solid #e2e8f0; border-radius: 8px; }
                .validation-code { background: #1e293b; color: white; padding: 12px 20px; border-radius: 8px; font-family: monospace; font-size: 14px; font-weight: bold; letter-spacing: 1px; margin-top: 15px; }
                .movie-info { background: #fff; padding: 30px 40px; }
                .movie-title { font-size: 24px; font-weight: 700; color: #dc2626; text-transform: uppercase; margin-bottom: 20px; text-align: center; }
                .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px; }
                .info-item { background: #f1f5f9; padding: 15px; border-radius: 8px; border-left: 4px solid #667eea; }
                .info-label { font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 500; margin-bottom: 5px; }
                .info-value { font-size: 16px; font-weight: 600; color: #1e293b; }
                .seats-section { background: #fef3c7; border: 2px solid #f59e0b; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
                .seats-title { font-size: 16px; font-weight: 600; color: #92400e; margin-bottom: 10px; }
                .seats-numbers { font-size: 20px; font-weight: 700; color: #b45309; }
                .purchase-details { background: #f8fafc; padding: 25px 40px; border-top: 1px solid #e2e8f0; }
                .details-title { font-size: 18px; font-weight: 600; color: #1e293b; margin-bottom: 20px; text-align: center; }
                .details-list { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
                .total-section { background: #059669; color: white; padding: 20px; border-radius: 8px; text-align: center; margin-top: 20px; }
                .total-label { font-size: 14px; opacity: 0.9; margin-bottom: 5px; }
                .total-amount { font-size: 28px; font-weight: 700; }
                .instructions { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 20px; margin: 20px 40px; }
                .instructions-title { font-size: 16px; font-weight: 600; color: #1e40af; margin-bottom: 15px; display: flex; align-items: center; }
                .instructions ul { margin: 0; padding-left: 20px; }
                .instructions li { color: #1e40af; margin-bottom: 8px; }
                .footer { background: #1e293b; color: #94a3b8; padding: 25px 40px; text-align: center; }
                .footer-logo { font-size: 18px; font-weight: 600; color: white; margin-bottom: 10px; }
                .footer-text { font-size: 13px; line-height: 1.5; }
                .ticket-number { background: #dc2626; color: white; padding: 8px 15px; border-radius: 6px; font-weight: 600; font-size: 12px; position: absolute; top: 20px; right: 20px; }
                
                /* Fallback para clientes que no soportan CSS Grid */
                @media screen and (max-width: 600px) {
                    .info-grid { display: block; }
                    .info-item { margin-bottom: 10px; }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <!-- Header -->
                <div class="header">
                    <div class="ticket-number">#' . substr($ticketNumber, -8) . '</div>
                    <div class="logo">🎬 DREAM MOVIE</div>
                    <div class="tagline">PREMIUM CINEMA EXPERIENCE</div>
                </div>

                <!-- Saludo -->
                <div class="greeting">
                    <h2>¡Hola ' . htmlspecialchars($nombre) . '!</h2>
                    <p>Su compra se procesó exitosamente. Aquí tienes la entrada digital.</p>
                </div>

                <!-- Sección QR -->
                <div class="qr-section">
                    <div class="qr-title">CÓDIGO DE VALIDACIÓN</div>
                    <div class="qr-subtitle">Presenta este código QR al ingresar al cine</div>
                    
                    <div class="qr-container">
                        <!-- Usar la imagen embebida con CID -->
                        <img src="cid:qr_code" alt="Código QR de entrada" class="qr-image">
                    </div>
                    
                    <div class="validation-code">
                        CÓDIGO: ' . $ticketNumber . '
                    </div>
                </div>

                <!-- Información de la película -->
                <div class="movie-info">
                    <div class="movie-title">' . htmlspecialchars($pelicula) . '</div>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">📅 FECHA</div>
                            <div class="info-value">' . $fechaFormateada . '</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">🕐 HORA</div>
                            <div class="info-value">' . $hora . '</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">🏢 CINE</div>
                            <div class="info-value">' . htmlspecialchars($cine) . '</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">🎪 SALA</div>
                            <div class="info-value">SALA ' . $sala . '</div>
                        </div>
                    </div>

                    <div class="seats-section">
                        <div class="seats-title">🪑 TUS ASIENTOS</div>
                        <div class="seats-numbers">' . strtoupper($butacas) . '</div>
                    </div>
                </div>

                <!-- Detalles de compra -->
                <div class="purchase-details">
                    <div class="details-title">DETALLE DE LA COMPRA</div>
                    <div class="details-list">
                        ' . $detalleEntradasHTML . '
                        <div class="total-section">
                            <div class="total-label">TOTAL PAGADO</div>
                            <div class="total-amount">₡' . number_format($total, 0) . '</div>
                        </div>
                    </div>
                </div>

                <!-- Instrucciones -->
                <div class="instructions">
                    <div class="instructions-title">
                        📱 PASOS PARA CANJEAR TUS ENTRADAS
                    </div>
                    <ul>
                        <li>Llega al cine 15 minutos antes de la función</li>
                        <li>Presenta este código QR en la taquilla o entrada</li>
                        <li>El personal escaneará tu código para validar tu entrada</li>
                        <li>Conserva este correo durante toda la función</li>
                        <li>Disfruta de la película 🍿</li>
                    </ul>
                </div>

                <!-- Footer -->
                <div class="footer">
                    <div class="footer-logo">DREAM MOVIE</div>
                    <div class="footer-text">
                        Ticket #' . $ticketNumber . '<br>
                        Dream Movie © 2025 | www.dreammovie.com<br>
                        La mejor experiencia cinematográfica
                    </div>
                </div>
            </div>
        </body>
        </html>';
        
        $mail->isHTML(true);
        $mail->Body = $mailBody;

        // Enviar el correo
        $result = $mail->send();
        
        // Limpiar el archivo temporal
        if (file_exists($tempQRFile)) {
            unlink($tempQRFile);
        }
        
        return $result;
        
    } catch (Exception $e) {
        error_log("Error enviando correo: " . $mail->ErrorInfo);
        
        // Limpiar el archivo temporal en caso de error
        if (isset($tempQRFile) && file_exists($tempQRFile)) {
            unlink($tempQRFile);
        }
        
        return false;
    }
}

// FUNCIÓN ALTERNATIVA USANDO SOLO BASE64 (Si la anterior no funciona)
function enviarCorreoConQRAlternativo($nombre, $correo, $tarjeta, $cine, $dia, $pelicula, $sala, $hora, $adulto, $nino, $mayor, $butacas, $total) {
    // Generar número de ticket único
    $ticketNumber = 'DM-' . date('YmdHis') . '-' . rand(100, 999);

    // Generar QR con configuración simplificada
    $qrData = "Ticket: $ticketNumber\nCine: $cine\nFecha: $dia\nPelicula: $pelicula\nSala: $sala\nHora: $hora\nEntradas: A:$adulto N:$nino M:$mayor\nButacas: $butacas\nTotal: ₡$total";

    try {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_M,  // Cambiar nivel de corrección
            'scale' => 10,  // Aumentar escala
            'imageBase64' => false,
        ]);

        $qr = new QRCode($options);
        $qrImageData = $qr->render($qrData);
        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImageData);

        // ENVIAR CORREO
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('', 'Dream Movie');
        $mail->addAddress($correo, $nombre);
        $mail->Subject = '🎬 Tu entrada para ' . $pelicula . ' - Dream Movie';
        
        // HTML simplificado con QR embebido en base64
        $mailBody = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #1a1a2e, #0f3460); color: white; padding: 30px; text-align: center; }
                .logo { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
                .content { padding: 30px; }
                .qr-section { text-align: center; background: #f8f9fa; padding: 30px; margin: 20px 0; border-radius: 10px; }
                .qr-title { font-size: 18px; font-weight: bold; margin-bottom: 20px; color: #333; }
                .qr-container { background: white; display: inline-block; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                .movie-info { background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px 0; }
                .info-row { display: flex; justify-content: space-between; margin: 10px 0; padding: 10px; background: white; border-radius: 5px; }
                .total { background: #4caf50; color: white; text-align: center; padding: 20px; border-radius: 10px; font-size: 20px; font-weight: bold; }
                .footer { background: #333; color: #ccc; padding: 20px; text-align: center; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="logo">🎬 DREAM MOVIE</div>
                    <p>Tu entrada digital</p>
                </div>
                
                <div class="content">
                    <h2>¡Hola ' . htmlspecialchars($nombre) . '!</h2>
                    <p>Tu compra se procesó exitosamente.</p>
                    
                    <div class="qr-section">
                        <div class="qr-title">CÓDIGO QR DE ENTRADA</div>
                        <div class="qr-container">
                            <img src="' . $qrBase64 . '" alt="Código QR" style="width: 200px; height: 200px; display: block;">
                        </div>
                        <p style="margin-top: 15px; background: #333; color: white; padding: 10px; border-radius: 5px; font-family: monospace; font-weight: bold;">' . $ticketNumber . '</p>
                    </div>
                    
                    <div class="movie-info">
                        <h3>' . htmlspecialchars($pelicula) . '</h3>
                        <div class="info-row"><span>Cine:</span><span>' . htmlspecialchars($cine) . '</span></div>
                        <div class="info-row"><span>Fecha:</span><span>' . date('d/m/Y', strtotime($dia)) . '</span></div>
                        <div class="info-row"><span>Hora:</span><span>' . $hora . '</span></div>
                        <div class="info-row"><span>Sala:</span><span>' . $sala . '</span></div>
                        <div class="info-row"><span>Asientos:</span><span>' . strtoupper($butacas) . '</span></div>
                    </div>
                    
                    <div class="total">
                        TOTAL: ₡' . number_format($total, 0) . '
                    </div>
                    
                    <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 20px; border-radius: 10px; margin-top: 20px;">
                        <h4 style="color: #8b6f00; margin-top: 0;">Instrucciones:</h4>
                        <ul style="color: #8b6f00;">
                            <li>Presenta este código QR al llegar al cine</li>
                            <li>Llega 15 minutos antes de la función</li>
                            <li>Ten este correo disponible en tu móvil</li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer">
                    <p>Dream Movie © 2025 | Ticket #' . $ticketNumber . '</p>
                </div>
            </div>
        </body>
        </html>';
        
        $mail->isHTML(true);
        $mail->Body = $mailBody;
        
        return $mail->send();
        
    } catch (Exception $e) {
        error_log("Error enviando correo alternativo: " . $e->getMessage());
        return false;
    }
}
    ?>

</body>
</html>