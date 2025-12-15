<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: index.php");
    exit;
}

$id_liga = (int)$_GET['id'];

// confirmar que a liga pertence ao utilizador
$check = mysqli_query($ligaBD,
    "SELECT * FROM ligas 
     WHERE id_liga=$id_liga 
     AND id_utilizador={$_SESSION['id_utilizador']}"
);

if (mysqli_num_rows($check) == 0) {
    die("Acesso negado.");
}

// apagar jogos
mysqli_query($ligaBD, "DELETE FROM jogos WHERE id_liga=$id_liga");

// apagar relação liga-equipas
mysqli_query($ligaBD, "DELETE FROM ligas_equipas WHERE id_liga=$id_liga");

// apagar liga
mysqli_query($ligaBD, "DELETE FROM ligas WHERE id_liga=$id_liga");

header("Location: ligas.php");
exit;
