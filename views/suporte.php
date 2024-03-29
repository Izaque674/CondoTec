<?php
session_start();
require_once('../models/conexao.php');
require_once('../models/suporte_crud.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['nomeUsuario'])) {
    // Se não estiver logado, redireciona de volta para a página de login
    header("Location: ../models/login.php");
    exit();
}

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Obtém o ID do usuário logado
$id_usuario = $_SESSION['id'];

// Consulta para obter o número do apartamento do usuário logado
$query = $pdo->prepare("SELECT numero_apartamento FROM apartamentos WHERE id = :id");
$query->bindParam(':id', $id_usuario);
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

// Verifica se a consulta retornou algum resultado
if ($resultado) {
    $numero_apartamento = $resultado['numero_apartamento'];
} else {
    $numero_apartamento = "Número de apartamento não registrado";
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Cria uma instância da classe Suporte e preenche os atributos
    $suporte = new Suporte();
    $suporte->__set('categoria', $_POST['categoria']);
    $suporte->__set('informacao', $_POST['informacao']);
    $suporte->__set('descricao', $_POST['descricao']);
    $suporte->__set('carater', $_POST['carater']);

    // Cria uma instância do Suporte_crud para inserir os dados
    $suporte_crud = new Suporte_crud($conexao, $suporte);
    $suporte_crud->inserir();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
</head>
<body>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <h3>Solicitado por <?php echo $_SESSION['nomeUsuario']; ?> Apartamento <?php echo $numero_apartamento; ?> </h3>
                <h4>Número de registro <?php echo $_SESSION['id']; ?></h4>
            </div>
            <h3>Categoria</h3>
            <select name="categoria" class="">
                <option></option>
                <option>Água</option>
                <option>Eletricidade</option>
                <option>Garagem</option>
                <option>Manutenção</option>
                <option>Salão</option>
            </select>
            <br/>
            <h3>Informe sobre o que se trata</h3>
            <div>
                <input name="informacao" placeholder="Informação...">
            </div>
            <br/>
            <h3>Descrição</h3>
            <textarea name="descricao" placeholder="Informe seu problema..."></textarea>
            <br/>
            <h3>Carater</h3>
            <select name="carater" class="">
                <option></option>
                <option>Normal</option>
                <option>Urgencia</option>
            </select>
            <br/><br/>
            <button type="submit">Registrar</button>
        </form>
        <button onclick="window.location.href='home.php'">Home</button>
    </div>
</body>
</html>
