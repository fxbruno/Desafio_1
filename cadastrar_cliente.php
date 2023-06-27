<?php
require_once 'conexao.php';
require_once 'vendedor.php';
require_once 'cliente.php';

session_start();

// Verificar se o formulário de cadastro de cliente foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $email = $_POST["email"];
    $endereco_cobranca = $_POST["endereco_cobranca"];
    $endereco_entrega = $_POST["endereco_entrega"];

    // Verificar se o ID do vendedor está definido na sessão
    if (!isset($_SESSION["vendedor_id"])) {
        echo "Acesso não autorizado!";
        exit();
    }

    $vendedor_id = $_SESSION["vendedor_id"];

    // Inicializar a conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Inserir o cliente no banco de dados relacionado ao vendedor
    $sql = "INSERT INTO clientes (nome, idade, email, endereco_cobranca, endereco_entrega, vendedor_id) VALUES ('$nome', $idade, '$email', '$endereco_cobranca', '$endereco_entrega', $vendedor_id)";
    if ($conn->query($sql) === TRUE) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar cliente: " . $conn->error;
    }

    // Fechar a conexão com o banco de dados
    $conn->close();

    // Redirecionar para a página de gerenciar clientes
    header("Location: gerenciar_clientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Cliente</title>
</head>
<body>
    <h1>Cadastrar Cliente</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br><br>
        
        <label for="idade">Idade:</label>
        <input type="number" name="idade" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label for="endereco_cobranca">Endereço de Cobrança:</label>
        <input type="text" name="endereco_cobranca" required><br><br>
        
        <label for="endereco_entrega">Endereço de Entrega:</label>
        <input type="text" name="endereco_entrega" required><br><br>
        
        <input type="submit" value="Cadastrar">
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>Cliente cadastrado com sucesso!</p>
        <p><a href="gerenciar_clientes.php">Ir para Gerenciamento de Clientes</a></p>
    <?php endif; ?>
</body>
</html>
