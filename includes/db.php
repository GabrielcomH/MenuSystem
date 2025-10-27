<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'cardapio_db';


$conn = new mysqli($host, $user, $pass, $dbname);


if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Se quiser testar, descomente a linha abaixo
 //echo "Conexão bem-sucedida!";
?>
