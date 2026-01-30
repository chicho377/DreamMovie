<?php
include 'includes/conexion.php';
$sala = $_POST['sala'];
$dia = $_POST['dia'];
$hora = $_POST['hora'];
$pelicula = $_POST['pelicula'];
$ocupados = [];

// Buscar la función
$funcion = mysqli_query($conn, "SELECT id FROM funciones WHERE id_sala='$sala' AND id_pelicula='$pelicula' AND fecha='$dia' AND hora='$hora'");
if($row = mysqli_fetch_assoc($funcion)){
    $id_funcion = $row['id'];
    $res = mysqli_query($conn, "SELECT asiento FROM entradas WHERE id_funcion='$id_funcion'");
    while($r = mysqli_fetch_assoc($res)){
        $ocupados[] = $r['asiento'];
    }
}

echo json_encode($ocupados);
?>
