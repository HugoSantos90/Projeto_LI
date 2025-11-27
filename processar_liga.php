<?php
session_start();
require_once "conexao.php";

// Verifica se está autenticado
if (!isset($_SESSION['id_utilizador'])) {
    $_SESSION['erro_liga'] = "É necessário estar autenticado para criar uma liga.";
    header("Location: ligas.php");
    exit;
}

// Recebe dados do formulário
$nome_liga = $_POST['nome_liga'] ?? '';
$epoca     = $_POST['epoca'] ?? '';
$utilizador_id = $_SESSION['id_utilizador'];

// Validação básica
if ($nome_liga == '' || $epoca == '') {
    $_SESSION['erro_liga'] = "Preenche todos os campos!";
    header("Location: ligas.php");
    exit;
}

// Inserir na tabela ligas
$insert = "INSERT INTO ligas (nome_liga, epoca, id_utilizador) 
           VALUES ('$nome_liga', '$epoca', '$utilizador_id')";

if (mysqli_query($ligaBD, $insert)) {
    $_SESSION['sucesso_liga'] = "Liga criada com sucesso!";
    header("Location: ligas.php");
    exit;
} else {
    $_SESSION['erro_liga'] = "Erro ao criar liga: " . mysqli_error($ligaBD);
    header("Location: ligas.php");
    exit;
}
?>
