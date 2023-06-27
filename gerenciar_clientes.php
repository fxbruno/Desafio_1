<?php
require_once 'conexao.php';
require_once 'cliente.php';
session_start();

// Verificar se o ID do vendedor está definido na sessão
if (!isset($_SESSION["vendedor_id"])) {
    echo "Acesso não autorizado!";
    exit();
}

$vendedor_id = $_SESSION["vendedor_id"];
$sql = "SELECT nome FROM vendedores WHERE id = $vendedor_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomeVendedor = $row["nome"];
} else {
    $nomeVendedor = "Vendedor Desconhecido";
}

// Inicializar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Função para editar um cliente
function editarCliente($conn, $cliente) {
    $id = $cliente->getId();
    $nome = $cliente->getNome();
    $idade = $cliente->getIdade();
    $email = $cliente->getEmail();
    $endereco_cobranca = $cliente->getEnderecoCobranca();
    $endereco_entrega = $cliente->getEnderecoEntrega();

    $sql = "UPDATE clientes SET nome = '$nome', idade = $idade, email = '$email', endereco_cobranca = '$endereco_cobranca', endereco_entrega = '$endereco_entrega' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Cliente atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar cliente: " . $conn->error;
    }
}

// Função para excluir um cliente
function excluirCliente($conn, $clienteId) {
    $sql = "DELETE FROM clientes WHERE id = $clienteId";
    if ($conn->query($sql) === TRUE) {
        echo "Cliente excluído com sucesso!";
    } else {
        echo "Erro ao excluir cliente: " . $conn->error;
    }
}

// Verificar se o formulário de edição de cliente foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar_cliente"])) {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $email = $_POST["email"];
    $endereco_cobranca = $_POST["endereco_cobranca"];
    $endereco_entrega = $_POST["endereco_entrega"];

    $cliente = new Cliente($id, $nome, $idade, $email, $endereco_cobranca, $endereco_entrega);
    editarCliente($conn, $cliente);
}

// Verificar se o ID do cliente para exclusão foi fornecido
if (isset($_GET["excluir_cliente"])) {
    $clienteId = $_GET["excluir_cliente"];
    excluirCliente($conn, $clienteId);
}

// Obter a lista de clientes vinculados ao vendedor
$sql = "SELECT id, nome, idade, email, endereco_cobranca, endereco_entrega FROM clientes WHERE vendedor_id = $vendedor_id";
$result = $conn->query($sql);

// Fechar a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Clientes</title>
</head>
<body>
<?php
    echo "<p>Bem-vindo, " . $nomeVendedor . "!</p>";
    ?>
    <h1>Gerenciar Clientes</h1>
    <a href="cadastrar_cliente.php">Cadastrar Novo Cliente</a><br><br>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Nome</th><th>Idade</th><th>Email</th><th>Endereço de Cobrança</th><th>Endereço de Entrega</th><th>Ações</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $cliente = new Cliente($row['id'], $row['nome'], $row['idade'], $row['email'], $row['endereco_cobranca'], $row['endereco_entrega']);
            echo "<tr>";
            echo "<td>".$cliente->getNome()."</td>";
            echo "<td>".$cliente->getIdade()."</td>";
            echo "<td>".$cliente->getEmail()."</td>";
            echo "<td>".$cliente->getEndereco_cobranca()."</td>";
            echo "<td>".$cliente->getEndereco_entrega()."</td>";
            echo "<td><a href='editar_cliente.php?id=".$cliente->getId()."'>Editar</a> | <a href='gerenciar_clientes.php?excluir_cliente=".$cliente->getId()."'>Excluir</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum cliente encontrado.";
    }
    ?>
</body>
</html>
