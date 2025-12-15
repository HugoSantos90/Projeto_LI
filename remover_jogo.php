<?php
include 'conexao.php';
if (isset($_GET['id_jogo'], $_GET['id_liga'])) {
    $id_jogo = (int)$_GET['id_jogo'];
    $id_liga = (int)$_GET['id_liga'];
    mysqli_query($ligaBD, "DELETE FROM jogos WHERE id_jogo='$id_jogo'");
}
header("Location: liga_detalhe.php?id=$id_liga");
exit;
