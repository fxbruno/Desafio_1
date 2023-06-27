<?php
$servername = "localhost";
$username = "root";
$password = "Batata.2021";
$dbname = "desafio";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
