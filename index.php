<?php include "cabecalho.php"; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Liga de Futebol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
        }

        /* HERO SECTION */
        .hero {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 80px 40px;
            margin-top: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            position: relative;
        }

        .hero p {
            font-size: 1.3rem;
            color: #555;
            margin-top: 20px;
            font-weight: 400;
            position: relative;
        }

        .btn-comecar {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 15px 50px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(245, 87, 108, 0.4);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .btn-comecar:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(245, 87, 108, 0.6);
        }

        .btn-minhas-ligas {
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            border: none;
            color: white;
            padding: 15px 50px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(255, 216, 155, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            z-index: 1;
        }

        .btn-minhas-ligas:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(255, 216, 155, 0.6);
            color: white;
        }

        /* ALERTS */
        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.95);
            color: white;
        }

        .alert-success {
            background: rgba(25, 135, 84, 0.95);
            color: white;
        }

        /* SECTION TITLE */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffffff;
            text-align: center;
            margin-bottom: 50px;
            position: relative;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        /* FEATURE CARDS */
        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 40px 30px;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.3);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .icon-box {
            font-size: 4rem;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .icon-box {
            transform: scale(1.2) rotate(5deg);
        }

        .feature-card h4 {
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
        }

        /* FLOATING ELEMENTS */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero {
                padding: 50px 30px;
            }

            .section-title {
                font-size: 2rem;
            }

            .btn-comecar, .btn-minhas-ligas {
                padding: 12px 35px;
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>


<!-- ============================================
     MENSAGENS DE ERRO/SUCESSO
=============================================== -->
<div class="container mt-3">
    <?php if (isset($_SESSION['erro_login'])): ?>
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_SESSION['erro_login'] ?>
        </div>
        <?php unset($_SESSION['erro_login']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['erro_registo'])): ?>
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $_SESSION['erro_registo'] ?>
        </div>
        <?php unset($_SESSION['erro_registo']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['sucesso_registo'])): ?>
        <div class="alert alert-success text-center">
            <i class="fas fa-check-circle me-2"></i>
            <?= $_SESSION['sucesso_registo'] ?>
        </div>
        <?php unset($_SESSION['sucesso_registo']); ?>
    <?php endif; ?>
</div>


<!-- ============================================
     SECÇÃO HERO (topo da página)
=============================================== -->
<div class="container">
    <div class="hero text-center">
        <div class="floating">
            <h1>Organiza e Gere as Tuas Ligas de Futebol</h1>
            <p>Acompanha classificações, adiciona equipas, regista jogos e administra toda a competição.</p>

            <?php if (!isset($_SESSION['id_utilizador'])): ?>
                <button class="btn btn-comecar mt-4" data-bs-toggle="modal" data-bs-target="#modalLogin">
                    <i class="fas fa-rocket me-2"></i>Começar Agora
                </button>
            <?php else: ?>
                <a href="ligas.php" class="btn-minhas-ligas mt-4">
                    <i class="fas fa-futbol me-2"></i>Ir para as Minhas Ligas
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>



<!-- ============================================
     FUNCIONALIDADES PRINCIPAIS
=============================================== -->
<div class="container mt-5 mb-5 pb-5">

    <h2 class="section-title">O que podes fazer com esta aplicação?</h2>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="icon-box">
                    <i class="fas fa-trophy"></i>
                </div>
                <h4>Criar Ligas</h4>
                <p>Cria competições personalizadas com temporada, descrição e regras próprias.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="icon-box">
                    <i class="fas fa-users"></i>
                </div>
                <h4>Gerir Equipas</h4>
                <p>Adiciona equipas, edita nomes, escudos e gere os plantéis.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="icon-box">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h4>Registar Jogos</h4>
                <p>Guarda resultados, golos marcados, pontos e estatísticas automaticamente.</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">

        <div class="col-md-4 offset-md-2">
            <div class="feature-card text-center">
                <div class="icon-box">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h4>Classificação Automática</h4>
                <p>Acompanha ranking, pontos, golos e desempenho em tempo real.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="feature-card text-center">
                <div class="icon-box">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h4>Gestão Pessoal</h4>
                <p>O teu perfil controla as tuas ligas, equipas e todas as informações.</p>
            </div>
        </div>

    </div>

</div>

</body>
</html>