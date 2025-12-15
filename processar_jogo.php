<?php
include 'conexao.php'; // Só a conexão, sem HTML ou modais

$id_liga = $_POST['id_liga'];
$equipa_casa = $_POST['equipa_casa'];
$equipa_fora = $_POST['equipa_fora'];
$data_jogo = $_POST['data_jogo'];
$golos_casa = $_POST['golos_casa'];
$golos_fora = $_POST['golos_fora'];

if ($equipa_casa == $equipa_fora) {
    die("Erro: A equipa da casa e a equipa de fora não podem ser iguais.");
}

$sql = "INSERT INTO jogos 
(id_liga, equipa_casa, equipa_fora, golos_casa, golos_fora, data_jogo)
VALUES ('$id_liga', '$equipa_casa', '$equipa_fora', 
        '$golos_casa', '$golos_fora', '$data_jogo')";

if (mysqli_query($ligaBD, $sql)) {
    header("Location: liga_detalhe.php?id=$id_liga");
    exit;
} else {
    echo "Erro ao criar jogo: " . mysqli_error($ligaBD);
}
