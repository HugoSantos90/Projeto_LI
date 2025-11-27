<?php
$ligaBD = mysqli_connect('localhost', 'root', '');
if (!$ligaBD) {
    echo "<br>Não foi possível fazer a ligação ao servidor";
    exit;
}

$conexaoBD = mysqli_select_db($ligaBD, "bd_projetoli");
if (!$conexaoBD) {
    echo "<br>Não foi possível conectar à base de dados";
    exit;
}

// Opcional: definir charset para evitar problemas com acentos
mysqli_set_charset($ligaBD, "utf8");
?>
