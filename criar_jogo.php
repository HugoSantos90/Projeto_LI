<?php
include 'cabecalho.php';
include 'conexao.php';

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id_liga'])) {
    header("Location: ligas.php");
    exit;
}

$id_liga = (int) $_GET['id_liga'];

// Buscar equipas da liga
$sql_equipas = "
    SELECT e.id_equipa, e.nome_equipa
    FROM ligas_equipas le
    JOIN equipas e ON le.id_equipa = e.id_equipa
    WHERE le.id_liga = '$id_liga'
";

$result = mysqli_query($ligaBD, $sql_equipas);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Jogo</title>
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
            max-width: 800px;
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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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
            margin-bottom: 25px;
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
            color: #11998e;
        }

        .form-control-custom {
            border: 2px solid rgba(17, 153, 142, 0.2);
            border-radius: 15px;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
        }

        .form-control-custom:focus {
            border-color: #11998e;
            box-shadow: 0 0 0 0.25rem rgba(17, 153, 142, 0.25);
            background: white;
            transform: translateY(-2px);
            outline: none;
        }

        select.form-control-custom {
            cursor: pointer;
        }

        /* VS SEPARATOR */
        .vs-separator {
            text-align: center;
            position: relative;
            margin: 30px 0;
            z-index: 1;
        }

        .vs-badge {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2rem;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }

        /* SCORE SECTION */
        .score-section {
            background: rgba(17, 153, 142, 0.05);
            border-radius: 20px;
            padding: 25px;
            margin: 30px 0;
            border: 2px dashed rgba(17, 153, 142, 0.2);
            position: relative;
            z-index: 1;
        }

        .score-title {
            text-align: center;
            font-weight: 700;
            color: #11998e;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .score-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* BUTTONS */
        .btn-criar {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(17, 153, 142, 0.4);
            width: 100%;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            cursor: pointer;
        }

        .btn-criar:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(17, 153, 142, 0.6);
            background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
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
            color: #11998e;
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
            color: #11998e;
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

            .score-inputs {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="container-custom">

    <h1 class="page-title">
        <i class="fas fa-futbol me-2"></i>Criar Jogo
    </h1>
    <p class="page-subtitle">Regista um novo jogo na competição</p>

    <div class="form-card">
        <div class="form-card-icon">
            <i class="fas fa-calendar-check"></i>
        </div>

        <form method="POST" action="processar_jogo.php" style="position: relative; z-index: 1;">

            <input type="hidden" name="id_liga" value="<?= $id_liga ?>">

            <!-- EQUIPA CASA -->
            <div class="form-group-custom">
                <label class="form-label-custom">
                    <i class="fas fa-home"></i> Equipa da Casa
                </label>
                <select name="equipa_casa" class="form-control form-control-custom" required>
                    <option value="">Selecione a equipa da casa</option>
                    <?php while ($e = mysqli_fetch_assoc($result)): ?>
                        <option value="<?= $e['id_equipa'] ?>"><?= htmlspecialchars($e['nome_equipa']) ?></option>
                    <?php endwhile; ?>
                </select>
                <div class="helper-text">
                    <i class="fas fa-info-circle"></i>
                    Equipa que joga em casa
                </div>
            </div>

            <!-- VS SEPARATOR -->
            <div class="vs-separator">
                <span class="vs-badge">VS</span>
            </div>

            <?php $result = mysqli_query($ligaBD, $sql_equipas); ?>

            <!-- EQUIPA FORA -->
            <div class="form-group-custom">
                <label class="form-label-custom">
                    <i class="fas fa-plane-departure"></i> Equipa de Fora
                </label>
                <select name="equipa_fora" class="form-control form-control-custom" required>
                    <option value="">Selecione a equipa visitante</option>
                    <?php while ($e = mysqli_fetch_assoc($result)): ?>
                        <option value="<?= $e['id_equipa'] ?>"><?= htmlspecialchars($e['nome_equipa']) ?></option>
                    <?php endwhile; ?>
                </select>
                <div class="helper-text">
                    <i class="fas fa-info-circle"></i>
                    Equipa visitante
                </div>
            </div>

            <!-- DATA DO JOGO -->
            <div class="form-group-custom">
                <label class="form-label-custom">
                    <i class="fas fa-calendar-alt"></i> Data do Jogo
                </label>
                <input 
                    type="date" 
                    name="data_jogo" 
                    class="form-control form-control-custom"
                    value="<?= date('Y-m-d') ?>"
                    required>
                <div class="helper-text">
                    <i class="fas fa-info-circle"></i>
                    Quando será realizado o jogo
                </div>
            </div>

            <!-- RESULTADO -->
            <div class="score-section">
                <div class="score-title">
                    <i class="fas fa-chart-bar me-2"></i>Resultado do Jogo
                </div>
                <div class="score-inputs">
                    <div class="form-group-custom mb-0">
                        <label class="form-label-custom">
                            <i class="fas fa-futbol"></i> Golos Casa
                        </label>
                        <input 
                            type="number" 
                            name="golos_casa" 
                            class="form-control form-control-custom" 
                            min="0" 
                            value="0"
                            required>
                    </div>

                    <div class="form-group-custom mb-0">
                        <label class="form-label-custom">
                            <i class="fas fa-futbol"></i> Golos Fora
                        </label>
                        <input 
                            type="number" 
                            name="golos_fora" 
                            class="form-control form-control-custom" 
                            min="0" 
                            value="0"
                            required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-criar">
                <i class="fas fa-check-circle me-2"></i>Criar Jogo
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