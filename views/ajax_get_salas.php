<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/conexion.php';

if (!isset($_POST['cine']) || !isset($_POST['dia']) || !isset($_POST['pelicula'])) {
  echo '<option value="">Error: Parámetros incompletos</option>';
  exit;
}

$cine = $_POST['cine'];
$dia = $_POST['dia'];
$pelicula = $_POST['pelicula'];

if (!$conn) {
  echo '<option value="">Error: No hay conexión a la base de datos</option>';
  exit;
}

$query = "SELECT DISTINCT s.id, s.nombre FROM funciones f JOIN salas s ON f.id_sala = s.id WHERE f.fecha = '$dia' AND f.id_pelicula = '$pelicula' AND s.id_cine = '$cine'";
$result = mysqli_query($conn, $query);
if (!$result) {
  echo '<option value="">Error en la consulta: '.mysqli_error($conn).'</option>';
  exit;
}

echo '<option value="">Seleccione una sala</option>';
if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
  }
}else{
  echo '<option value="">No hay salas disponibles</option>';
}
?>
