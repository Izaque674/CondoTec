<?php
// Inclua o arquivo que contém a definição da classe LoginController
require_once 'C:/xampp/htdocs/aulas/CondoTec/config/LoginController.php';

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Cria uma instância do LoginController para lidar com o cadastro
    $loginController = new LoginController();
    // Aqui você pode manipular os dados do formulário se necessário
}
?>

