<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --accent-color: #ffd700;
    }

    .navbar-premium {
        background: var(--primary-gradient);
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
        padding: 1rem 0;
        position: relative;
        overflow: hidden;
    }

    .navbar-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { left: -100%; }
        100% { left: 200%; }
    }

    .navbar-brand-custom {
        font-size: 1.6rem;
        font-weight: 700;
        color: #fff !important;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: transform 0.3s ease;
    }

    .navbar-brand-custom:hover {
        transform: scale(1.05);
    }

    .brand-icon {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 12px;
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.95) !important;
        font-weight: 500;
        padding: 0.6rem 1.2rem !important;
        margin: 0 0.2rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
        letter-spacing: 0.3px;
    }

    .navbar-nav .nav-link::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: var(--accent-color);
        transform: translateX(-50%);
        transition: width 0.3s ease;
        border-radius: 2px;
    }

    .navbar-nav .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }

    .navbar-nav .nav-link:hover::before {
        width: 60%;
    }

    .btn-entrar {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.4);
        color: #fff !important;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .btn-entrar:hover {
        background: #fff;
        color: #667eea !important;
        border-color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
    }

    .btn-criar-conta {
        background: var(--secondary-gradient);
        border: none;
        color: #fff !important;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
    }

    .btn-criar-conta:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 87, 108, 0.6);
    }

    .welcome-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1.2rem;
        border-radius: 20px;
        color: #fff;
        font-weight: 500;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .welcome-badge strong {
        color: var(--accent-color);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .btn-sair {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        border: none;
        color: #fff !important;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
    }

    .btn-sair:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
    }

    .navbar-toggler {
        border: 2px solid rgba(255, 255, 255, 0.5);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
    }

    @media (max-width: 991px) {
        .navbar-nav {
            padding: 1rem 0;
        }
        
        .navbar-nav .nav-link {
            margin: 0.2rem 0;
        }

        .d-flex.align-items-center {
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
            padding: 1rem 0;
        }

        .btn-entrar, .btn-criar-conta, .btn-sair {
            width: 100%;
        }

        .welcome-badge {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-premium">
    <div class="container">
        <a class="navbar-brand navbar-brand-custom" href="index.php">
            <span class="brand-icon">
                <i class="fas fa-trophy"></i>
            </span>
            Gestor de Ligas
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">

            <ul class="navbar-nav me-auto ms-lg-4">
                <?php if (isset($_SESSION['id_utilizador'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="ligas.php">
                        <i class="fas fa-list-ul me-1"></i> Minhas Ligas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="criar_ligas.php">
                        <i class="fas fa-plus-circle me-1"></i> Criar Liga
                    </a>
                </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center gap-2">

                <?php if (!isset($_SESSION['id_utilizador'])): ?>

                    <button class="btn btn-entrar" data-bs-toggle="modal" data-bs-target="#modalLogin">
                        <i class="fas fa-sign-in-alt me-1"></i> Entrar
                    </button>
                    <button class="btn btn-criar-conta" data-bs-toggle="modal" data-bs-target="#modalRegisto">
                        <i class="fas fa-user-plus me-1"></i> Criar Conta
                    </button>

                <?php else: ?>

                    <div class="welcome-badge">
                        <i class="fas fa-user-circle"></i>
                        <span>Olá, <strong><?= $_SESSION['nome_utilizador'] ?></strong></span>
                    </div>
                    <a href="logout.php" class="btn btn-sair">
                        <i class="fas fa-sign-out-alt me-1"></i> Sair
                    </a>

                <?php endif; ?>

            </div>

        </div>
    </div>
</nav>

<!-- MODAIS -->
<?php include "modais_login_registo.php"; ?>