<nav class="navbar navbar-expand-lg navbar-dark main-nav">
        
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'cartelera' ? 'active' : ''; ?>" href="cartelera.php">
                            <i class="bi bi-film"></i> CARTELERA
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'promociones' ? 'active' : ''; ?>" href="promociones.php">
                            <i class="bi bi-tag"></i> PROMOCIONES
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'salas' ? 'active' : ''; ?>" href="salas.php">
                            <i class="bi bi-projector"></i> SALAS Y FORMATOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $current_page == 'comprar' ? 'active' : ''; ?>" href="comprar.php">
                            <i class="bi bi-cart"></i> COMPRAR
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>