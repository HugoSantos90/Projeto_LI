<?php
include "conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: index.php");
    exit;
}

// Verificar ID da liga
if (!isset($_GET['id_liga']) || empty($_GET['id_liga'])) {
    header("Location: ligas.php");
    exit;
}

$id_liga = (int)$_GET['id_liga'];
$mensagem = "";
$tipo_mensagem = "warning";

/* ================= PROCESSAR FORM ================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_equipa = trim($_POST['nome_equipa']);

    if ($nome_equipa == "") {
        $mensagem = "Preenche o nome da equipa!";
        $tipo_mensagem = "danger";
    } else {

        // verificar se existe
        $check = mysqli_query(
            $ligaBD,
            "SELECT id_equipa FROM equipas WHERE nome_equipa='$nome_equipa'"
        );

        if (mysqli_num_rows($check) > 0) {
            $row = mysqli_fetch_assoc($check);
            $id_equipa = $row['id_equipa'];
        } else {
            mysqli_query(
                $ligaBD,
                "INSERT INTO equipas (nome_equipa) VALUES ('$nome_equipa')"
            );
            $id_equipa = mysqli_insert_id($ligaBD);
        }

        // associar à liga
        $checkLiga = mysqli_query(
            $ligaBD,
            "SELECT * FROM ligas_equipas 
             WHERE id_liga='$id_liga' AND id_equipa='$id_equipa'"
        );

        if (mysqli_num_rows($checkLiga) == 0) {
            mysqli_query(
                $ligaBD,
                "INSERT INTO ligas_equipas (id_liga, id_equipa)
                 VALUES ('$id_liga','$id_equipa')"
            );

            $_SESSION['mensagem_equipa'] = "Equipa adicionada com sucesso!";
            header("Location: liga_detalhe.php?id=$id_liga");
            exit;
        } else {
            $mensagem = "Esta equipa já está na liga.";
            $tipo_mensagem = "warning";
        }
    }
}

/* ================= HTML SÓ A PARTIR DAQUI ================= */
include "cabecalho.php";

// buscar nome da liga
$resLiga = mysqli_query(
    $ligaBD,
    "SELECT nome_liga FROM ligas 
     WHERE id_liga='$id_liga' AND id_utilizador='{$_SESSION['id_utilizador']}'"
);
$liga = mysqli_fetch_assoc($resLiga);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Equipa</title>
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
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        /* PAGE TITLE */
        .page-title {
            text-align: center;
            margin: 40px 0 20px;
            color: white;
            font-size: 2.5rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 0.6s ease;
        }

        .liga-badge {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
            display: inline-block;
            margin-bottom: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
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

        /* ALERT */
        .alert-custom {
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            font-weight: 600;
            padding: 20px;
            animation: fadeIn 0.5s ease;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-warning-custom {
            background: rgba(255, 193, 7, 0.95);
            color: #856404;
        }

        .alert-danger-custom {
            background: rgba(220, 53, 69, 0.95);
            color: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* FORM CARD */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: fadeInUp 0.8s ease;
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
            pointer-events: none;
            z-index: 0;
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

        .form-card-icon {
            text-align: center;
            font-size: 4rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 30px;
            animation: bounce 2s ease infinite;
            position: relative;
            z-index: 1;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* FORM GROUP */
        .form-group-custom {
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .form-label-custom {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label-custom i {
            color: #667eea;
        }

        .form-control-custom {
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
        }

        .form-control-custom:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
            background: white;
            transform: translateY(-2px);
            outline: none;
        }

        .form-control-custom::placeholder {
            color: #999;
            font-weight: 400;
        }

        /* HELPER TEXT */
        .helper-text {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .helper-text i {
            color: #667eea;
        }

        /* BUTTONS */
        .btn-adicionar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            width: 100%;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            cursor: pointer;
        }

        .btn-adicionar:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .btn-voltar {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.5);
            color: white;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn-voltar:hover {
            background: white;
            color: #667eea;
            border-color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.3);
        }

        .btn-container {
            text-align: center;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .form-card {
                padding: 40px 30px;
            }

            .container-custom {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
<div class="container-custom">

    <h1 class="page-title">
        <i class="fas fa-users me-2"></i>Adicionar Equipa
    </h1>
    
    <div class="text-center">
        <div class="liga-badge">
            <i class="fas fa-trophy me-2"></i><?= htmlspecialchars($liga['nome_liga']) ?>
        </div>
    </div>

    <?php if ($mensagem != ""): ?>
        <div class="alert-custom <?= $tipo_mensagem == 'danger' ? 'alert-danger-custom' : 'alert-warning-custom' ?>">
            <i class="fas fa-exclamation-triangle"></i>
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <div class="form-card-icon">
            <i class="fas fa-shield-alt"></i>
        </div>

        <form method="POST" style="position: relative; z-index: 1;">
            
            <div class="form-group-custom">
                <label class="form-label-custom">
                    <i class="fas fa-flag"></i> Nome da Equipa
                </label>
                <input 
                    type="text" 
                    name="nome_equipa" 
                    class="form-control form-control-custom" 
                    placeholder="Ex: SL Benfica"
                    required
                    autofocus>
                <div class="helper-text">
                    <i class="fas fa-info-circle"></i>
                    Se a equipa já existir, será automaticamente associada à liga
                </div>
            </div>

            <button type="submit" class="btn-adicionar">
                <i class="fas fa-plus-circle me-2"></i>Adicionar à Liga
            </button>

        </form>
    </div>

    <div class="btn-container">
        <a href="liga_detalhe.php?id=<?= $id_liga ?>" class="btn-voltar">
            <i class="fas fa-arrow-left me-2"></i>Voltar à Liga
        </a>
    </div>

</div>
</body>
</html>