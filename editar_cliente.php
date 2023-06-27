<?php
require_once 'conexao.php';
require_once 'vendedor.php';
require_once 'cliente.php';

session_start();

// Verificar se o ID do vendedor está definido na sessão
if (!isset($_SESSION["vendedor_id"])) {
    echo "Acesso não autorizado!";
    exit();
}

// Verificar se o ID do cliente está definido na URL
if (!isset($_GET["id"])) {
    echo "Cliente não encontrado!";
    exit();
}

$vendedor_id = $_SESSION["vendedor_id"];
$cliente_id = $_GET["id"];

// Inicializar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o cliente pertence ao vendedor atual
$sql = "SELECT * FROM clientes WHERE id = $cliente_id AND vendedor_id = $vendedor_id";
$result = $conn->query($sql);
if ($result->num_rows != 1) {
    echo "Cliente não encontrado!";
    $conn->close();
    exit();
}

// Obter os dados do cliente
$row = $result->fetch_assoc();
$nome = $row["nome"];
$endereco_cobranca = $row["endereco_cobranca"];
$endereco_entrega = $row["endereco_entrega"];
$email = $row["email"];

// Verificar se o formulário de atualização de cliente foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $endereco_cobranca = $_POST["endereco_cobranca"];
    $endereco_entrega = $_POST["endereco_entrega"];
    $email = $_POST["email"];

    // Atualizar os dados do cliente no banco de dados
    $sql = "UPDATE clientes SET nome = '$nome', endereco_cobranca = '$endereco_cobranca', endereco_entrega = '$endereco_entrega', email = '$email' WHERE id = $cliente_id";
    if ($conn->query($sql) === TRUE) {
        echo "Cliente atualizado com sucesso!";
        // Redirecionar para o gerenciador de clientes
        header("Location: gerenciar_clientes.php");
        exit();
    } else {
        echo "Erro ao atualizar cliente: " . $conn->error;
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
</head>
<body>
    <h1>Editar Cliente</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $cliente_id; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo $nome; ?>" required><br><br>
        
        <label for="endereco_cobranca">Endereço de Cobrança:</label>
        <input type="text" name="endereco_cobranca" value="<?php echo $endereco_cobranca; ?>" required><br><br>
        
        <label for="endereco_entrega">Endereço de Entrega:</label>
        <input type="text" name="endereco_entrega" value="<?php echo $endereco_entrega; ?>" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required><br><br>
        
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
