<?php
session_start();
require_once('../models/conexao.php');

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
$id_usuario = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Consulta para obter o número do apartamento do usuário logado
$query = $pdo->prepare("SELECT numero_apartamento FROM apartamentos WHERE id = :id");
$query->bindParam(':id', $id_usuario);
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);

// Verifica se a consulta retornou algum resultado
if ($resultado && isset($resultado['numero_apartamento'])) {
    $numero_apartamento = $resultado['numero_apartamento'];
} else {
    $numero_apartamento = "Número de apartamento não registrado";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
    <link rel="stylesheet" href="../assets/estilo.css">
</head>
<body>
    <div>
        <h1>Bem vindo <?php echo isset($_SESSION['nomeUsuario']) ? $_SESSION['nomeUsuario'] : 'Usuário'; ?> apartamento <?php echo isset($numero_apartamento) ? $numero_apartamento : ''; ?> </h1>
        <h2>Número de registro <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?></h2>
    </div>

    <div>
        <button onclick="window.location.href='suporte.php'">Suporte</button>
    </div>
    <div>
        <button onclick="window.location.href='visualizar_sup.php'">Visualizar Suporte</button>
    </div>
    <div>
        <button onclick="window.location.href='garagem.php'">Cadastre seu carro</button>
    </div>

    <button onclick="window.location.href = 'mostrar_carros.php';">Ver Meus Carros</button>

    <button id="btnVisualizarBoletos">Visualizar Boletos</button>
<div id="listaBoletos"></div>

<script>
    document.getElementById('btnVisualizarBoletos').addEventListener('click', function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../models/obter_boletos.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var boletos = JSON.parse(xhr.responseText);
                exibirBoletos(boletos);
            }
        };
        xhr.send();
    });

    function exibirBoletos(boletos) {
    var listaBoletos = document.getElementById('listaBoletos');
    listaBoletos.innerHTML = ''; // Limpa o conteúdo anterior
    for (var i = 0; i < boletos.length; i++) {
        var boleto = boletos[i];
        var dataPagamento = boleto.data_pagamento ? ' - Pagamento: ' + boleto.data_pagamento : ''; // Verifica se há data de pagamento
        listaBoletos.innerHTML += '<p>' + boleto.nome_pagador + ' - R$ ' + boleto.valor + ' - ' + boleto.status + ' - Vencimento: ' + boleto.data_vencimento + dataPagamento + '</p>';
    }
}
</script>


    <br/>

    <?php if (isset($numero_apartamento) && $numero_apartamento == "Número de apartamento não registrado"): ?>
    <!-- Mostrar o formulário de registro apenas se o usuário ainda não tiver registrado um apartamento -->
    <form action="../models/registrar_ap.php" method="post">
        <div>
            <input name="numero_apartamento" placeholder="Informe o número do apartamento">
        </div>
        <button type="submit">Registrar</button>
    </form>
    <?php endif; ?>
    
    <br/>
    <form action="../models/logoff.php" method="post">
        <button type="submit">Sair</button>
    </form>
</body>
</html>