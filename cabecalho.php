<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    
</body>
</html>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="index.php">
            ⚽ Gestor de Ligas
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>

                <?php if (isset($_SESSION['id_utilizador'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="ligas.php">Minhas Ligas</a>
                </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex">
                <?php if (!isset($_SESSION['id_utilizador'])): ?>
                    <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#modalLogin">Login</button>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalRegisto">Registar</button>
                <?php else: ?>
                    <span class="text-light me-3">Olá, <strong><?= $_SESSION['nome_utilizador'] ?></strong></span>
                    <a href="logout.php" class="btn btn-danger">Sair</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</nav>

<!-- MODAL LOGIN -->
<div class="modal fade" id="modalLogin">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="processar_login.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nome_utilizador" class="form-control mb-3" placeholder="Nome de utilizador" required>
                    <input type="password" name="palavra_passe" class="form-control" placeholder="Palavra-passe" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL REGISTO -->
<div class="modal fade" id="modalRegisto">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="processar_registo.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Criar Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nome_utilizador" class="form-control mb-3" placeholder="Nome de utilizador" required>
                    <input type="email" name="email" class="form-control mb-3" placeholder="Email (opcional)">
                    <input type="password" name="palavra_passe" class="form-control" placeholder="Palavra-passe" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Registar</button>
                </div>
            </form>
        </div>
    </div>
</div>
