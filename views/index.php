<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>CondoTec</title>
    <link rel="shortcut icon" type="image/jpg" href="../assets/img/favicon-32x32.png"/>
</head>
<body>
    <div>
        <form action="../models/login.php" method="post">
            <div>
                <input name="email" type="email" class="" placeholder="E-mail">
            </div>
            <div>
                <input name="senha" type="password" class="" placeholder="Senha">
            </div>
            <?php if (isset($_GET['login']) && $_GET['login'] == 'erro') {?>
            <div class="text-danger">
                Usuário ou senha inválidos
            </div>
            <?php } ?>
            <button type="submit">Entrar</button>
        </form>
        <button onclick="window.location.href='cadastrar.php'">Novo Cadastro</button>
    </div>
</body>
</html>
