<?php
$servername = "localhost";
$username = "root";
$password = "Batata.2021";
$dbname = "desafio";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configurar o modo de erro do PDO para o modo de exceção
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Falha na conexão: " . $e->getMessage());
}
