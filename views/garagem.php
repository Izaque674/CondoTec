<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro de Carros na Garagem</title>
    <link rel="stylesheet" href="../assets/estilo.css">
</head>
<body>
    <h1>Cadastro de Carros na Garagem</h1>

    <form action="../models/registrar_carro.php" method="post">
        <div>
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" required>
        </div>
        <div>
            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" required>
        </div>
        <div>
            <label for="cor">Cor:</label>
            <input type="text" id="cor" name="cor" required>
        </div>
        <div>
            <label for="placa">Placa:</label>
            <input type="text" id="placa" name="placa" required>
        </div>
        <button type="submit">Registrar Carro</button>
    </form>

    <br/>
    <button onclick="window.location.href='home.php'">Voltar para a Página Inicial</button>
</body>
</html>
