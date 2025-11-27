<?php
session_start();
session_unset();
session_destroy();

// Redirecionar para página principal
header("Location: index.php");
exit;
?>
