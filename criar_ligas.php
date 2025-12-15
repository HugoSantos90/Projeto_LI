<?php
// IMPORTANTE: Processar ANTES de qualquer output
session_start();
include "conexao.php";

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: index.php");
    exit;
}

$mensagem = "";

// PROCESSAR CRIAÇÃO DE LIGA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_liga'], $_POST['epoca'])) {
    $nome_liga = mysqli_real_escape_string($ligaBD, $_POST['nome_liga']);
    $epoca     = mysqli_real_escape_string($ligaBD, $_POST['epoca']);
    $id_user   = $_SESSION['id_utilizador'];

    if ($nome_liga != "" && $epoca != "") {
        $sql_insert = "INSERT INTO ligas (nome_liga, epoca, id_utilizador)
                       VALUES ('$nome_liga', '$epoca', '$id_user')";
        if (mysqli_query($ligaBD, $sql_insert)) {
            $_SESSION['mensagem_liga'] = "Liga criada com sucesso!";
            header("Location: ligas.php");
            exit;
        } else {
            $mensagem = "Erro ao criar liga: " . mysqli_error($ligaBD);
        }
    } else {
        $mensagem = "Preenche todos os campos!";
    }
}

// Agora sim, incluir o cabeçalho (que tem HTML)
include "cabecalho.php";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Liga</title>
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
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }

        /* PAGE TITLE */
        .page-title {
            text-align: center;
            margin: 40px 0;
            color: white;
            font-size: 2.8rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 0.6s ease;
        }

        .page-subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-top: -20px;
            margin-bottom: 40px;
            font-weight: 400;
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
            background: rgba(255, 255, 255, 0.95);
            color: #667eea;
            font-weight: 600;
            padding: 20px;
            animation: fadeIn 0.5s ease;
            margin-bottom: 30px;
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

        /* FORM GROUPS */
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

        /* BUTTONS */
        .btn-criar {
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

        .btn-criar:hover {
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
        <i class="fas fa-plus-circle me-2"></i>Criar Nova Liga
    </h1>
    <p class="page-subtitle">Preenche os dados abaixo para criar a tua competição</p>


    <div class="form-card">
        <div class="form-card-icon">
            <i class="fas fa-trophy"></i>
        </div>

        <form method="POST" action="" style="position: relative; z-index: 1;">
            
            <div class="form-group-custom">
                <label class="form-label-custom">
                    <i class="fas fa-flag"></i> Nome da Liga
                </label>
                <input 
                    type="text" 
                    name="nome_liga" 
                    class="form-control form-control-custom" 
                    placeholder="Ex: Liga dos Campeões 2025"
                    required>
                <div class="helper-text">
                    <i class="fas fa-info-circle"></i>
                    Escolhe um nome único e memorável
                </div>
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">
                    <i class="fas fa-calendar-alt"></i> Época
                </label>
                <input 
                    type="text" 
                    name="epoca" 
                    class="form-control form-control-custom" 
                    placeholder="Ex: 2025/2026"
                    required>
                <div class="helper-text">
                    <i class="fas fa-info-circle"></i>
                    Define o período da competição
                </div>
            </div>

            <button type="submit" class="btn-criar">
                <i class="fas fa-rocket me-2"></i>Criar Liga
            </button>

        </form>
    </div>

    <div class="btn-container">
        <a href="ligas.php" class="btn-voltar">
            <i class="fas fa-arrow-left me-2"></i>Voltar às Ligas
        </a>
    </div>

</div>
</body>
</html>