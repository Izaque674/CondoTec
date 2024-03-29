<?php
session_start(); // Inicializa a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['nomeUsuario'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: ../models/login.php");
    exit();
}

require_once('../models/conexao.php');

// Conexão com o banco de dados
$conexao = new Conexao();
$pdo = $conexao->conectar();

// Obtém o ID do usuário logado
$id_usuario = $_SESSION['id'];

// Consulta para obter os carros registrados pelo usuário
$query = $pdo->prepare("SELECT * FROM carros_garagem WHERE usuario_id = :id_usuario");
$query->bindParam(':id_usuario', $id_usuario);
$query->execute();
$carros = $query->fetchAll(PDO::FETCH_ASSOC);

// Verifica se houve algum erro na consulta
if (!$carros) {
    $mensagem_erro = "Não foi possível recuperar os carros registrados.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Carros</title>
    <link rel="stylesheet" href="../assets/estilo.css"> <!-- Arquivo CSS para estilos -->
</head>
<body>
    <h1>Meus Carros Registrados</h1>

    <?php if (isset($mensagem_erro)): ?>
        <p><?php echo $mensagem_erro; ?></p>
    <?php else: ?>
        <div class="car-list">
            <?php foreach ($carros as $carro): ?>
                <div class="car">
                    <h2><?php echo $carro['marca'] . ' ' . $carro['modelo']; ?></h2>
                    <p>Cor: <?php echo $carro['cor']; ?></p>
                    <p>Placa: <?php echo $carro['placa']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <br>
    <button onclick="window.location.href='../views/home.php';">Voltar para Home</button>
</body>
</html>
