<?php
// Configuración básica
$page_title = "Dream Movie - Inicio";
$current_page = "inicio";
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
    <link href="./assets/css/carrusel.css" rel="stylesheet">
    <link rel="icon" href="./assets/icons/icon.png" type="image/png">
</head>
<body>
    <!-- Header -->
    <?php include './includes/header.php'; ?>

    <!-- Navigation -->
    <?php include './includes/nav.php'; ?>

    <!-- Hero Section con Carrusel -->
    <?php include './includes/carrusel.php'; ?>


    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Cartelera Section -->
                    <section class="cartelera-section">
                        <div class="section-header" data-aos="fade-up" data-aos-delay="100">
                            <h3 class="section-title">
                                <i class="bi bi-calendar-week"></i> CARTELERA Semanal
                            </h3>
                        </div>
                        <div class="movie-grid">
                            <!-- Movie Cards will be populated here -->
                            <div class="movie-card" data-aos="fade-up" data-aos-delay="200">
                                <div class="movie-poster">
                                    <img src="./assets/img/dragon2.jpg" alt="Cómo entrenar a tu dragón" class="img-fluid">
                                    <div class="movie-overlay">
                                        <span class="rating">S/C</span>
                                    </div>
                                </div>
                                <div class="movie-info">
                                    <h5 class="movie-title">Cómo entrenar a tu dragón</h5>
                                    <p class="movie-times">
                                        <i class="bi bi-clock"></i> 1:45 PM | 4:20 PM | 6:55 PM
                                    </p>
                                </div>
                            </div>

                            <div class="movie-card" data-aos="fade-up" data-aos-delay="300">
                                <div class="movie-poster">
                                    <img src="./assets/img/lilo y stitch.jpg" alt="Lilo & Stitch" class="img-fluid">
                                    <div class="movie-overlay">
                                        <span class="rating">TP</span>
                                    </div>
                                </div>
                                <div class="movie-info">
                                    <h5 class="movie-title">Lilo & Stitch</h5>
                                    <p class="movie-times">
                                        <i class="bi bi-clock"></i> 2:00 PM | 4:30 PM | 7:55 PM
                                    </p>
                                </div>
                            </div>

                            <div class="movie-card" data-aos="fade-up" data-aos-delay="600">
                                <div class="movie-poster">
                                    <img src="./assets/img/misionimposible.jpg" alt="Misión: Imposible" class="img-fluid">
                                    <div class="movie-overlay">
                                        <span class="rating">+12</span>
                                    </div>
                                </div>
                                <div class="movie-info">
                                    <h5 class="movie-title">Misión: Imposible</h5>
                                    <p class="movie-times">
                                        <i class="bi bi-clock"></i> 2:15 PM | 4:30 PM | 7:00 PM
                                    </p>
                                </div>
                            </div>

                            <div class="movie-card" data-aos="fade-up" data-aos-delay="700">
                                <div class="movie-poster">
                                    <img src="./assets/img/superman 2025.jpg" alt="Superman 2025" class="img-fluid">
                                    <div class="movie-overlay">
                                        <span class="rating">TP</span>
                                    </div>
                                </div>
                                <div class="movie-info">
                                    <h5 class="movie-title">Superman 2025</h5>
                                    <p class="movie-times">
                                        <i class="bi bi-clock"></i> 5:00 PM | 8:00 PM
                                    </p>
                                </div>
                            </div>

                            <div class="movie-card" data-aos="fade-up" data-aos-delay="800">
                                <div class="movie-poster">
                                    <img src="./assets/img/conjuro.jpg" alt="Conjuro 4" class="img-fluid">
                                    <div class="movie-overlay">
                                        <span class="rating">+18</span>
                                    </div>
                                </div>
                                <div class="movie-info">
                                    <h5 class="movie-title">Conjuto 4</h5>
                                    <p class="movie-times">
                                        <i class="bi bi-clock"></i> 4:00 PM | 9:00 PM
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-4">
                    <!-- Sidebar -->
                    <aside class="sidebar">
                        <div class="sidebar-section" data-aos="fade-up">
                            <h4 class="sidebar-title">
                                <i class="bi bi-star"></i> Próximos estrenos
                            </h4>
                            <div class="upcoming-movies">
                                <div class="upcoming-movie" data-aos="fade-up" data-aos-delay="400">
                                    <img src="./assets/img/elio.jpg" alt="ELIO" class="img-fluid">
                                    <div class="upcoming-info">
                                        <h6>ELIO</h6>
                                        <p style="color: #fff;">Próximamente</p>
                                    </div>
                                </div>
                                <div class="upcoming-movie" data-aos="fade-up" data-aos-delay="400">
                                    <img src="./assets/img/F1.jpg" alt="F1" class="img-fluid">
                                    <div class="upcoming-info">
                                        <h6>F1</h6>
                                        <p style="color: #fff;">Próximamente</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-section" data-aos="fade-up" data-aos-delay="500">
                            <h4 class="sidebar-title">
                                <i class="bi bi-calendar-event"></i> Próximamente
                            </h4>
                            <div class="coming-soon">
                                <p class="text-center">Mantente atento a nuestros próximos estrenos</p>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>

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