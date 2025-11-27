

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Liga de Futebol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f4f4f4;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
        }
        .header-logo {
            font-size: 1.7rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
<?php include "cabecalho.php"; ?>

<!-- ============================================
     MENSAGENS DE ERRO/SUCESSO
=============================================== -->
<div class="container mt-3">
    <?php if (isset($_SESSION['erro_login'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_SESSION['erro_login'] ?>
        </div>
        <?php unset($_SESSION['erro_login']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro_registo'])): ?>
        <div class="alert alert-danger text-center">
            <?= $_SESSION['erro_registo'] ?>
        </div>
        <?php unset($_SESSION['erro_registo']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['sucesso_registo'])): ?>
        <div class="alert alert-success text-center">
            <?= $_SESSION['sucesso_registo'] ?>
        </div>
        <?php unset($_SESSION['sucesso_registo']); ?>
    <?php endif; ?>
</div>

<!-- ============================================
     CONTEÚDO PRINCIPAL
=============================================== -->
<div class="container mt-4">

    <div class="text-center mb-4">
        <h1 class="fw-bold">Bem-vindo ao Gestor de Ligas!</h1>
        <p class="lead">
            Organiza competições, cria equipas, regista jogos e acompanha classificações de forma simples.
        </p>
    </div>

    <!-- Secções de destaque -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4 class="card-title">🏆 Criar Liga</h4>
                    <p class="card-text">Organiza as tuas próprias competições de futebol.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4 class="card-title">⚽ Gestão de Equipas</h4>
                    <p class="card-text">Adiciona equipas, escudos e gere estatísticas.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h4 class="card-title">📊 Classificação</h4>
                    <p class="card-text">Vê pontos, golos, golos sofridos e muito mais.</p>
                </div>
            </div>
        </div>

    </div>
</div>



</body>
</html>
