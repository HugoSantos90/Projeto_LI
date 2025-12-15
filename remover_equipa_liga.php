<?php
include 'conexao.php';
if (isset($_GET['id_liga'], $_GET['id_equipa'])) {
    $id_liga = (int)$_GET['id_liga'];
    $id_equipa = (int)$_GET['id_equipa'];
    mysqli_query($ligaBD, "DELETE FROM ligas_equipas WHERE id_liga='$id_liga' AND id_equipa='$id_equipa'");
}
header("Location: liga_detalhe.php?id=$id_liga");
exit;
