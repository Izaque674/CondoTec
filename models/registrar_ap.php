<?php
session_start(); // Inicializa a sessão

require_once('C:/xampp/htdocs/aulas/CondoTec/models/conexao.php');

$conexao = new Conexao();
$pdo = $conexao->conectar();

// Verifica se os dados do carro foram enviados via POST
if(isset($_POST['marca']) && isset($_POST['modelo']) && isset($_POST['cor']) && isset($_POST['placa'])) {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $cor = $_POST['cor'];
    $placa = $_POST['placa'];
    
    // Obtém o ID do usuário logado
    $id_usuario = $_SESSION['id'];

    // Verifica quantos carros o usuário já possui registrados na garagem
    $query = $pdo->prepare("SELECT COUNT(*) AS total_carros FROM carros_garagem WHERE usuario_id = :id_usuario");
    $query->bindParam(':id_usuario', $id_usuario);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Verifica se o número de carros já atingiu o limite de 2
    if ($result['total_carros'] >= 2) {
        echo "Você já possui o limite máximo de carros registrados na garagem.";
    } else {
        // Insere o novo carro na garagem
        $query = $pdo->prepare("INSERT INTO carros_garagem (marca, modelo, cor, placa, usuario_id) VALUES (:marca, :modelo, :cor, :placa, :usuario_id)");
        $query->bindParam(':marca', $marca);
        $query->bindParam(':modelo', $modelo);
        $query->bindParam(':cor', $cor);
        $query->bindParam(':placa', $placa);
        $query->bindParam(':usuario_id', $id_usuario);

        if($query->execute()) {
            echo "Carro registrado na garagem com sucesso.";
            header("Location: ../views/home.php");
            exit();
        } else {
            echo "Erro ao registrar o carro na garagem: " . $pdo->errorInfo()[2];
        }
    }
}
?>
