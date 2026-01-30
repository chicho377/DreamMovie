<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/conexion.php';

if (!isset($_POST['cine']) || !isset($_POST['dia'])) {
    echo '<option value="">Error: Parámetros incompletos</option>';
    exit;
}

$cine = $_POST['cine'];
$dia = $_POST['dia'];

if (!$conn) {
    echo '<option value="">Error: No hay conexión a la base de datos</option>';
    exit;
}

$query = "SELECT DISTINCT p.id, p.titulo FROM funciones f JOIN peliculas p ON f.id_pelicula = p.id WHERE f.fecha = '$dia' AND f.id_sala IN (SELECT id FROM salas WHERE id_cine = '$cine')";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo '<option value="">Error en la consulta: '.mysqli_error($conn).'</option>';
    exit;
}

echo '<option value="">Seleccione una película</option>';
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo '<option value="'.$row['id'].'">'.$row['titulo'].'</option>';
    }
}else{
    echo '<option value="">No hay películas disponibles</option>';
}
?>