<?php
require_once 'conexao.php';

class Vendedor {
    private $conn;
    
    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $this->conn->connect_error);
        }
    }
    
    public function cadastrar($nome, $cpf, $login, $senha) {
        // Verificar se o login já existe no banco de dados
        $sql = "SELECT id FROM vendedores WHERE login = '$login'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return "Login já existe. Por favor, escolha outro.";
        }
        
        // Inserir novo vendedor no banco de dados
        $sql = "INSERT INTO vendedores (nome, cpf, login, senha) VALUES ('$nome', '$cpf', '$login', '$senha')";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return "Erro ao cadastrar vendedor: " . $this->conn->error;
        }
    }
    
    public function autenticar($login, $senha) {
        // Verificar se o login e a senha correspondem a um vendedor no banco de dados
        $sql = "SELECT id, nome FROM vendedores WHERE login = '$login' AND senha = '$senha'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return [
                'id' => $row['id'],
                'nome' => $row['nome']
            ];
        } else {
            return false;
        }
    }
    
    public function __destruct() {
        $this->conn->close();
    }
}
