<?php
session_start();
require_once "conexao.php";

// Verifica se está autenticado
if (!isset($_SESSION['id_utilizador'])) {
    header("Location: index.php");
    exit;
}

// Liga selecionada (passada por GET)
$liga_id = $_GET['liga_id'] ?? 0;

// Verifica se liga_id é válido
if ($liga_id == 0) {
    echo "Liga inválida.";
    exit;
}

// Mensagens de sucesso/erro
$mensagem = $_SESSION['mensagem_equipa'] ?? '';
unset($_SESSION['mensagem_equipa']);

// Listar equipas da liga
$query = "SELECT * FROM equipas WHERE liga_id='$liga_id' ORDER BY id_equipa DESC";
$result = mysqli_query($ligaBD, $query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Equipas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h2>Equipas da Liga</h2>

    <?php if ($mensagem != ""): ?>
        <div class="alert alert-info"><?= $mensagem ?></div>
    <?php endif; ?>

    <!-- Formulário para adicionar equipa -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="processar_equipa.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="liga_id" value="<?= $liga_id ?>">
                <div class="mb-3">
                    <label class="form-label">Nome da Equipa</label>
                    <input type="text" name="nome_equipa" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Treinador</label>
                    <input type="text" name="treinador" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Cidade</label>
                    <input type="text" name="cidade" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Escudo (imagem)</label>
                    <input type="file" name="escudo" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Adicionar Equipa</button>
            </form>
        </div>
    </div>

    <!-- Lista de equipas -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Treinador</th>
            <th>Cidade</th>
            <th>Escudo</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($linha = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $linha['id_equipa'] ?></td>
                <td><?= $linha['nome_equipa'] ?></td>
                <td><?= $linha['treinador'] ?></td>
                <td><?= $linha['cidade'] ?></td>
                <td>
                    <?php if ($linha['escudo'] != ''): ?>
                        <img src="<?= $linha['escudo'] ?>" alt="Escudo" width="50">
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="ligas.php" class="btn btn-primary">Voltar às Ligas</a>

</div>
</body>
</html>
