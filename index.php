<?php
require_once 'conexao.php';
require_once 'vendedor.php';

session_start();

// Verificar se o formulário de login foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_vendedor"])) {
    $login = $_POST["login"];
    $senha = $_POST["senha"];

    // Criação de uma instância do vendedor
    $vendedor = new Vendedor($servername, $username, $password, $dbname);

    // Realizar a autenticação do vendedor
    $dadosVendedor = $vendedor->autenticar($login, $senha);
    if ($dadosVendedor) {
        // Definir a variável de sessão para armazenar o ID do vendedor logado
        $_SESSION["vendedor_id"] = $dadosVendedor['id'];

        // Redirecionar para a página de cadastro de clientes
        header("Location: cadastrar_cliente.php");
        exit();
    } else {
        echo "Login inválido!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Vendedores</title>
</head>
<body>
    <h1>Sistema de Vendedores</h1>

    <h2>Login</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="login">Login:</label>
        <input type="text" name="login" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br><br>

        <input type="submit" name="login_vendedor" value="Login">
    </form>

    <p>Não tem uma conta? <a href="cadastro_vendedor.php">Cadastre-se aqui</a>.</p>
</body>
</html>
