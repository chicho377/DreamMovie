<?php
// Configuración básica
$page_title = "Dream Movie - Cartelera";
$current_page = "cartelera";
?>
<!DOCTYPE html>
<html lang="es">
<head>
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
    <link href="./assets/css/cartelera.css" rel="stylesheet">
    <link rel="icon" href="./assets/icons/icon.png" type="image/png">
</head>
<body>
    <!-- Header -->
    <?php include './includes/header.php'; ?>

    <!-- Navigation -->
    <?php include './includes/nav.php'; ?>

    <!-- Main Content - Cartelera Completa -->
    <?php include './includes/mainCartelera.php'; ?>

    <!-- Social Media Section -->
    <?php include './includes/redes.php'; ?>

    <!-- Footer -->
    <?php include './includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset: 100,
            once: true
        });
    </script>
</body>
</html>