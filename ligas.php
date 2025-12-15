<?php
include 'cabecalho.php'; // inclui sessão, navbar, etc.
include 'conexao.php';   // ficheiro de ligação à BD

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: index.php");
    exit;
}

// Variável de mensagem
$mensagem = "";

// ===== PROCESSAR CRIAÇÃO DE LIGA =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_liga'], $_POST['epoca'])) {
    $nome_liga = mysqli_real_escape_string($ligaBD, $_POST['nome_liga']);
    $epoca     = mysqli_real_escape_string($ligaBD, $_POST['epoca']);
    $id_user   = $_SESSION['id_utilizador'];

    if ($nome_liga != "" && $epoca != "") {
        $sql_insert = "INSERT INTO ligas (nome_liga, epoca, id_utilizador)
                       VALUES ('$nome_liga', '$epoca', '$id_user')";
        if (mysqli_query($ligaBD, $sql_insert)) {
            $mensagem = "Liga criada com sucesso!";
        } else {
            $mensagem = "Erro ao criar liga: " . mysqli_error($ligaBD);
        }
    } else {
        $mensagem = "Preenche todos os campos!";
    }
}

// ===== LISTAR AS LIGAS DO UTILIZADOR =====
$id_user = $_SESSION['id_utilizador'];
$sql = "SELECT id_liga, nome_liga, epoca FROM ligas WHERE id_utilizador = '$id_user' ORDER BY id_liga DESC";
$result = mysqli_query($ligaBD, $sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Ligas</title>
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
            padding-bottom: 50px;
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

        .container-custom {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* PAGE TITLE */
        .page-title {
            text-align: center;
            margin: 40px 0;
            color: white;
            font-size: 3rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 0.6s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* MENSAGEM */
        .alert-custom {
            max-width: 600px;
            margin: 0 auto 30px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            color: #667eea;
            font-weight: 600;
            padding: 20px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: white;
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .empty-state p {
            font-size: 1.2rem;
            opacity: 0.8;
            margin-bottom: 30px;
        }

        .btn-criar-primeira {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(245, 87, 108, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-criar-primeira:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(245, 87, 108, 0.6);
            color: white;
        }

        /* LIGAS GRID */
        .ligas-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* LIGA CARD */
        .liga-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        .liga-card::before {
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

        .liga-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(102, 126, 234, 0.4);
        }

        .liga-card:hover::before {
            opacity: 1;
        }

        .liga-icon {
            font-size: 3rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .liga-card:hover .liga-icon {
            transform: scale(1.2) rotate(5deg);
        }

        .liga-card h2 {
            margin: 0 0 15px;
            font-size: 1.6rem;
            font-weight: 700;
            color: #333;
            position: relative;
        }

        .liga-card p {
            color: #666;
            font-size: 1rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .liga-card p i {
            color: #667eea;
        }

        /* BOTÃO ELIMINAR */
        .btn-eliminar {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            border: none;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
            transition: all 0.3s ease;
            z-index: 10;
            font-size: 1.1rem;
        }

        .btn-eliminar:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.6);
            background: linear-gradient(135deg, #ee5a6f 0%, #ff6b6b 100%);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .ligas-container {
                grid-template-columns: 1fr;
                padding: 10px;
            }

            .empty-state h3 {
                font-size: 1.5rem;
            }

            .empty-state p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

<div class="container-custom">

    <h1 class="page-title">
        <i class="fas fa-trophy me-3"></i>Minhas Ligas
    </h1>

    <!-- Mensagem -->
    <?php if ($mensagem != ""): ?>
        <div class="alert alert-custom">
            <i class="fas fa-check-circle me-2"></i><?= $mensagem ?>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <!-- ESTADO VAZIO -->
        <div class="empty-state">
            <i class="fas fa-futbol"></i>
            <h3>Ainda não tens ligas criadas</h3>
            <p>Começa por criar a tua primeira liga de futebol!</p>
            <a href="criar_ligas.php" class="btn-criar-primeira">
                <i class="fas fa-plus-circle me-2"></i>Criar Primeira Liga
            </a>
        </div>
    <?php else: ?>
        <!-- LISTA DE LIGAS EM BLOCOS -->
        <div class="ligas-container">
            <?php while ($liga = mysqli_fetch_assoc($result)): ?>
                <div class="liga-card" onclick="location.href='liga_detalhe.php?id=<?= $liga['id_liga'] ?>'">

                    <!-- BOTÃO ELIMINAR -->
                    <button 
                        class="btn-eliminar"
                        onclick="event.stopPropagation(); if(confirm('Tens a certeza que queres eliminar esta liga? Todos os dados serão apagados!')) { location.href='remover_liga.php?id=<?= $liga['id_liga'] ?>'; }"
                        title="Eliminar liga">
                        <i class="fas fa-trash"></i>
                    </button>

                    <div class="liga-icon">
                        <i class="fas fa-trophy"></i>
                    </div>

                    <h2><?= htmlspecialchars($liga['nome_liga']) ?></h2>
                    <p>
                        <i class="fas fa-calendar-alt"></i>
                        <strong>Época:</strong> <?= htmlspecialchars($liga['epoca']) ?>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>