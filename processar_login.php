<?php
session_start();
require_once "conexao.php"; // incluir a conexão clássica

// Receber dados do formulário
$nome_utilizador = $_POST['nome_utilizador'] ?? '';
$palavra_passe   = $_POST['palavra_passe'] ?? '';

if ($nome_utilizador === '' || $palavra_passe === '') {
    $_SESSION['erro_login'] = "Preenche todos os campos!";
    header("Location: index.php");
    exit;
}

// Consulta simples à base de dados (sem hash)
$query = "SELECT id_utilizador, nome_utilizador FROM utilizadores WHERE nome_utilizador='$nome_utilizador' AND palavra_passe='$palavra_passe'";
$result = mysqli_query($ligaBD, $query);

if (mysqli_num_rows($result) == 1) {
    $linha = mysqli_fetch_assoc($result);

    // Guardar dados na sessão
    $_SESSION['id_utilizador'] = $linha['id_utilizador'];
    $_SESSION['nome_utilizador'] = $linha['nome_utilizador'];

    header("Location: index.php"); // redireciona para página principal
    exit;
} else {
    $_SESSION['erro_login'] = "Nome de utilizador ou palavra-passe inválidos!";
    header("Location: index.php");
    exit;
}
?>
