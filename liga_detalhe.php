<?php
include 'cabecalho.php';
include 'conexao.php';

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ligas.php");
    exit;
}

$id_liga = (int)$_GET['id'];

/* ================= LIGA ================= */
$sql_liga = "SELECT * FROM ligas 
             WHERE id_liga='$id_liga' 
             AND id_utilizador='{$_SESSION['id_utilizador']}'";
$result_liga = mysqli_query($ligaBD, $sql_liga);

if (!$result_liga || mysqli_num_rows($result_liga) == 0) {
    die("Liga não encontrada ou não pertence ao utilizador.");
}

$liga = mysqli_fetch_assoc($result_liga);

/* ================= EQUIPAS ================= */
$sql_equipas = "
    SELECT e.id_equipa, e.nome_equipa
    FROM ligas_equipas le
    JOIN equipas e ON le.id_equipa = e.id_equipa
    WHERE le.id_liga='$id_liga'
";
$result_equipas = mysqli_query($ligaBD, $sql_equipas);

/* ================= JOGOS ================= */
$sql_jogos = "
    SELECT j.id_jogo, j.data_jogo, j.golos_casa, j.golos_fora,
           j.equipa_casa, j.equipa_fora,
           ec.nome_equipa AS casa,
           ef.nome_equipa AS fora
    FROM jogos j
    JOIN equipas ec ON j.equipa_casa = ec.id_equipa
    JOIN equipas ef ON j.equipa_fora = ef.id_equipa
    WHERE j.id_liga='$id_liga'
    ORDER BY j.data_jogo ASC
";
$result_jogos = mysqli_query($ligaBD, $sql_jogos);

/* ================= CLASSIFICAÇÃO ================= */
$classificacao = [];
if ($result_equipas) {
    while ($equipa = mysqli_fetch_assoc($result_equipas)) {
        $classificacao[$equipa['id_equipa']] = [
            'nome' => $equipa['nome_equipa'],
            'j' => 0,
            'v' => 0,
            'e' => 0,
            'd' => 0,
            'gm' => 0,
            'gs' => 0,
            'pts' => 0
        ];
    }
}

if ($result_jogos) {
    while ($jogo = mysqli_fetch_assoc($result_jogos)) {

        if (!is_numeric($jogo['golos_casa']) || !is_numeric($jogo['golos_fora'])) continue;

        $casa = $jogo['equipa_casa'];
        $fora = $jogo['equipa_fora'];

        $classificacao[$casa]['j']++;
        $classificacao[$fora]['j']++;

        $classificacao[$casa]['gm'] += $jogo['golos_casa'];
        $classificacao[$casa]['gs'] += $jogo['golos_fora'];

        $classificacao[$fora]['gm'] += $jogo['golos_fora'];
        $classificacao[$fora]['gs'] += $jogo['golos_casa'];

        if ($jogo['golos_casa'] > $jogo['golos_fora']) {
            $classificacao[$casa]['v']++;
            $classificacao[$casa]['pts'] += 3;
            $classificacao[$fora]['d']++;
        } elseif ($jogo['golos_casa'] < $jogo['golos_fora']) {
            $classificacao[$fora]['v']++;
            $classificacao[$fora]['pts'] += 3;
            $classificacao[$casa]['d']++;
        } else {
            $classificacao[$casa]['e']++;
            $classificacao[$fora]['e']++;
            $classificacao[$casa]['pts']++;
            $classificacao[$fora]['pts']++;
        }
    }
}

// ordenar classificação por pontos desc (mantendo as chaves/IDs)
uasort($classificacao, fn($a, $b) => $b['pts'] <=> $a['pts']);

// reset jogos para exibir
if ($result_jogos) mysqli_data_seek($result_jogos, 0);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($liga['nome_liga']) ?></title>
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
            padding: 20px;
        }

        /* PAGE HEADER */
        .page-header {
            text-align: center;
            margin: 40px 0;
            animation: fadeInDown 0.6s ease;
        }

        .page-title {
            color: white;
            font-size: 3rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.3rem;
            font-weight: 500;
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

        /* ACTION BUTTONS */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .btn-action {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(245, 87, 108, 0.4);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(245, 87, 108, 0.6);
            color: white;
        }

        .btn-action.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            box-shadow: 0 8px 20px rgba(56, 239, 125, 0.4);
        }

        .btn-action.success:hover {
            box-shadow: 0 12px 30px rgba(56, 239, 125, 0.6);
        }

        /* SECTION CARD */
        .section-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.5);
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

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* TABLE STYLING */
        .table-custom {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .table-custom thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table-custom thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
            text-align: center;
        }

        .table-custom tbody td {
            padding: 15px;
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-custom tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        /* BADGE STYLES */
        .badge-position {
            background: linear-gradient(135deg, #ffd89b 0%, #19547b 100%);
            color: white;
            font-weight: 700;
            padding: 8px 12px;
            border-radius: 50%;
            display: inline-block;
            width: 35px;
            height: 35px;
            line-height: 19px;
            text-align: center;
        }

        .team-name {
            font-weight: 600;
            color: #333;
            text-align: left !important;
        }

        .pts-highlight {
            font-weight: 700;
            color: #667eea;
            font-size: 1.1rem;
        }

        /* GAME CARD */
        .game-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            background: white;
            border-radius: 15px;
            margin-bottom: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .game-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .game-date {
            color: #999;
            font-size: 0.9rem;
            font-weight: 500;
            min-width: 100px;
        }

        .game-teams {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
            justify-content: center;
        }

        .team {
            font-weight: 600;
            color: #333;
            min-width: 150px;
            text-align: center;
        }

        .score {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.2rem;
            min-width: 80px;
            text-align: center;
        }

        /* BUTTONS */
        .btn-remove {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            border: none;
            color: white;
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
        }

        .btn-remove:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 107, 107, 0.5);
            color: white;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }

        .btn-voltar:hover {
            background: white;
            color: #667eea;
            border-color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.3);
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .game-row {
                flex-direction: column;
                gap: 10px;
            }

            .game-teams {
                flex-direction: column;
            }

            .team {
                min-width: auto;
            }

            .table-custom {
                font-size: 0.85rem;
            }

            .section-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container-custom">

    <!-- HEADER -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-trophy"></i> <?= htmlspecialchars($liga['nome_liga']) ?>
        </h1>
        <p class="page-subtitle">
            <i class="fas fa-calendar-alt me-2"></i>Época: <?= htmlspecialchars($liga['epoca']) ?>
        </p>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-buttons">
        <a href="criar_equipa.php?id_liga=<?= $liga['id_liga'] ?>" class="btn-action">
            <i class="fas fa-users"></i> Adicionar Equipa
        </a>
        <a href="criar_jogo.php?id_liga=<?= $liga['id_liga'] ?>" class="btn-action success">
            <i class="fas fa-futbol"></i> Adicionar Jogo
        </a>
    </div>

    <!-- CLASSIFICAÇÃO -->
    <div class="section-card">
        <h2 class="section-title">
            <i class="fas fa-chart-line"></i>
            Classificação
        </h2>

        <?php if (empty($classificacao)): ?>
            <div class="empty-state">
                <i class="fas fa-table"></i>
                <p>Ainda não existem equipas nesta liga.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="text-align: left;">Equipa</th>
                            <th>J</th>
                            <th>V</th>
                            <th>E</th>
                            <th>D</th>
                            <th>GM</th>
                            <th>GS</th>
                            <th>Pts</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $pos = 1; 
                        // Resetar o ponteiro das equipas
                        mysqli_data_seek($result_equipas, 0);
                        
                        foreach ($classificacao as $id_equipa => $e): 
                        ?>
                            <tr>
                                <td><span class="badge-position"><?= $pos++ ?></span></td>
                                <td class="team-name"><?= htmlspecialchars($e['nome']) ?></td>
                                <td><?= $e['j'] ?></td>
                                <td><?= $e['v'] ?></td>
                                <td><?= $e['e'] ?></td>
                                <td><?= $e['d'] ?></td>
                                <td><?= $e['gm'] ?></td>
                                <td><?= $e['gs'] ?></td>
                                <td><span class="pts-highlight"><?= $e['pts'] ?></span></td>
                                <td>
                                    <a href="remover_equipa_liga.php?id_liga=<?= $id_liga ?>&id_equipa=<?= $id_equipa ?>" 
                                       class="btn-remove"
                                       onclick="return confirm('Remover esta equipa da liga?')">
                                       <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- JOGOS -->
    <div class="section-card">
        <h2 class="section-title">
            <i class="fas fa-calendar-check"></i>
            Jogos
        </h2>

        <?php if ($result_jogos && mysqli_num_rows($result_jogos) > 0): ?>
            <?php while ($jogo = mysqli_fetch_assoc($result_jogos)): ?>
                <div class="game-row">
                    <div class="game-date">
                        <i class="fas fa-calendar me-1"></i>
                        <?= htmlspecialchars($jogo['data_jogo']) ?>
                    </div>
                    <div class="game-teams">
                        <div class="team"><?= htmlspecialchars($jogo['casa']) ?></div>
                        <div class="score">
                            <?= is_numeric($jogo['golos_casa']) ? $jogo['golos_casa'] : '-' ?>
                            -
                            <?= is_numeric($jogo['golos_fora']) ? $jogo['golos_fora'] : '-' ?>
                        </div>
                        <div class="team"><?= htmlspecialchars($jogo['fora']) ?></div>
                    </div>
                    <a href="remover_jogo.php?id_jogo=<?= $jogo['id_jogo'] ?>&id_liga=<?= $id_liga ?>" 
                       class="btn-remove"
                       onclick="return confirm('Remover este jogo?')">
                       <i class="fas fa-trash"></i>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-futbol"></i>
                <p>Ainda não existem jogos registados.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <a href="ligas.php" class="btn-voltar">
            <i class="fas fa-arrow-left"></i> Voltar às Ligas
        </a>
    </div>

</div>

</body>
</html>