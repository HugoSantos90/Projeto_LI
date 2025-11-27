<?php
session_start();
require_once "conexao.php";

// Receber dados do formulário
$nome_utilizador = $_POST['nome_utilizador'] ?? '';
$email           = $_POST['email'] ?? '';
$palavra_passe   = $_POST['palavra_passe'] ?? '';

if ($nome_utilizador === '' || $palavra_passe === '') {
    $_SESSION['erro_registo'] = "Preenche todos os campos obrigatórios!";
    header("Location: index.php");
    exit;
}

// Verificar se já existe o utilizador
$verifica = "SELECT id_utilizador FROM utilizadores WHERE nome_utilizador='$nome_utilizador'";
$result = mysqli_query($ligaBD, $verifica);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['erro_registo'] = "Nome de utilizador já existe!";
    header("Location: index.php");
    exit;
}

// Inserir novo utilizador
$insert = "INSERT INTO utilizadores (nome_utilizador, palavra_passe, email) 
           VALUES ('$nome_utilizador', '$palavra_passe', '$email')";

if (mysqli_query($ligaBD, $insert)) {
    // Iniciar sessão automaticamente
    $_SESSION['id_utilizador'] = mysqli_insert_id($ligaBD);
    $_SESSION['nome_utilizador'] = $nome_utilizador;
    header("Location: index.php");
    exit;
} else {
    $_SESSION['erro_registo'] = "Erro ao criar conta: " . mysqli_error($ligaBD);
    header("Location: index.php");
    exit;
}
?>
