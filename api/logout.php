<?php
session_start();
session_destroy();
header("Location: ../login.php");

$nomeUsuario = $_SESSION['user_nome'] ?? 'Usuário'; 


?>