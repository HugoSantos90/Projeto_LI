<?php
session_start();
require_once "conexao.php";

$nome_liga = $_POST['nome_liga'] ?? '';
$epoca = $_POST['epoca'] ?? '';
$utilizador_id = $_SESSION['id_utilizador'];

if ($nome_liga != "" && $epoca != "") {

    $sql = "INSERT INTO ligas (nome_liga, epoca, id_utilizador)
            VALUES ('$nome_liga', '$epoca', '$utilizador_id')";

    if (mysqli_query($ligaBD, $sql)) {
        $_SESSION['mensagem_liga'] = "Liga criada com sucesso!";
    } else {
        $_SESSION['mensagem_liga'] = "Erro ao criar liga: " . mysqli_error($ligaBD);
    }

} else {
    $_SESSION['mensagem_liga'] = "Preenche todos os campos!";
}

header("Location: ligas.php");
exit;
?>
