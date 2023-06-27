<?php
require_once 'conexao.php';
require_once 'vendedor.php';

// Verificar se o formulário de cadastro de vendedor foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cadastrar_vendedor"])) {
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $login = $_POST["login"];
    $senha = $_POST["senha"];

    // Criação de uma instância do vendedor
    $vendedor = new Vendedor($servername, $username, $password, $dbname);
    
    // Cadastro do vendedor no banco de dados
    $resultado = $vendedor->cadastrar($nome, $cpf, $login, $senha);
    
    if ($resultado === true) {
        // Redirecionar para a página de login
        header("Location: index.php");
        exit();
    } else {
        echo $resultado;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Vendedores - Cadastro Vendedor</title>
</head>
<body>
    <h2>Cadastrar Vendedor</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br><br>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" required><br><br>

        <label for="login">Login:</label>
        <input type="text" name="login" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br><br>

        <input type="submit" name="cadastrar_vendedor" value="Cadastrar">
    </form>

    <p>Já possui uma conta? <a href="index.php">Faça login aqui</a>.</p>
</body>
</html>
