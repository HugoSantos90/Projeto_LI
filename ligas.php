<?php
include "cabecalho.php";
if (!isset($_SESSION['id_utilizador'])) {
    header("Location: index.php");
    exit;
}

require_once "conexao.php";

$mensagem = "";

// Criar nova liga
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_liga = $_POST['nome_liga'] ?? '';
    $epoca     = $_POST['epoca'] ?? '';
    $utilizador_id = $_SESSION['id_utilizador'];

    if ($nome_liga != '' && $epoca != '') {
        $insert = "INSERT INTO ligas (nome_liga, epoca, id_utilizador)
                   VALUES ('$nome_liga', '$epoca', '$utilizador_id')";
        if (mysqli_query($ligaBD, $insert)) {
            $mensagem = "Liga criada com sucesso!";
        } else {
            $mensagem = "Erro ao criar liga: " . mysqli_error($ligaBD);
        }
    } else {
        $mensagem = "Preenche todos os campos!";
    }
}

// Listar ligas do utilizador
$id_utilizador = $_SESSION['id_utilizador'];
$query = "SELECT * FROM ligas WHERE id_utilizador='$id_utilizador' ORDER BY id_liga DESC";
$result = mysqli_query($ligaBD, $query);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Minhas Ligas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h2>Minhas Ligas</h2>

    <!-- Mensagem -->
    <?php if ($mensagem != ""): ?>
        <div class="alert alert-info"><?= $mensagem ?></div>
    <?php endif; ?>

    <!-- Formulário de criação -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="processar_liga.php">
                <div class="mb-3">
                    <label class="form-label">Nome da Liga</label>
                    <input type="text" name="nome_liga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Época</label>
                    <input type="text" name="epoca" class="form-control" placeholder="Ex: 2025/2026" required>
                </div>
                <button type="submit" class="btn btn-success">Criar Liga</button>
            </form>
        </div>
    </div>

    <!-- Listagem das ligas -->
    <h4>Ligas Criadas</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nome da Liga</th>
            <th>Época</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($linha = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $linha['id_liga'] ?></td>
                <td><?= $linha['nome_liga'] ?></td>
                <td><?= $linha['epoca'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn btn-primary">Voltar ao início</a>

</div>
</body>
</html>
