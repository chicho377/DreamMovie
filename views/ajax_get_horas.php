<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/conexion.php';

if (!isset($_POST['sala']) || !isset($_POST['dia']) || !isset($_POST['pelicula'])) {
  echo '<option value="">Error: Parámetros incompletos</option>';
  exit;
}

$sala = $_POST['sala'];
$dia = $_POST['dia'];
$pelicula = $_POST['pelicula'];

if (!$conn) {
  echo '<option value="">Error: No hay conexión a la base de datos</option>';
  exit;
}

$query = "SELECT id, hora FROM funciones WHERE fecha = '$dia' AND id_pelicula = '$pelicula' AND id_sala = '$sala'";
$result = mysqli_query($conn, $query);
if (!$result) {
  echo '<option value="">Error en la consulta: '.mysqli_error($conn).'</option>';
  exit;
}

echo '<option value="">Seleccione una hora</option>';
if(mysqli_num_rows($result) > 0){
  while($row = mysqli_fetch_assoc($result)){
    echo '<option value="'.$row['hora'].'">'.$row['hora'].'</option>';
  }
}else{
  echo '<option value="">No hay horarios disponibles</option>';
}
?>
