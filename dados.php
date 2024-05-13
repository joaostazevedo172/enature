<?php
session_start(); // Inicia a sessão para usar variáveis de sessão

// Verifica se o usuário está logado, caso contrário, redireciona de volta para o login.php
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

try {
    $conn = new PDO("mysql:host=localhost;dbname=login", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_SESSION['user_id'];

    // Consulta para obter os dados do usuário usando o ID fornecido pela sessão
    $query = $conn->prepare("SELECT * FROM estilo WHERE id = :id");
    $query->bindParam(':id', $user_id);
    $query->execute();

    if ($query->rowCount() == 1) {
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $imagem = $row['foto'];
    } else {
        // Caso ocorra algum problema na obtenção dos dados do usuário, redirecionar de volta para o login.php
        header('Location: login.php');
        exit();
    }
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados do Usuário</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f5f5f5;
            color: white;
            font-family: Arial, sans-serif;
        }

        .caixa__login {
            background-color: #333;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .caixa__login h2 {
            margin-bottom: 20px;
        }

        .caixa__login img {
            width: 300px;
            height: 300px;
            border-radius: 30%;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="caixa__login">
        <h2>Dados do Usuário</h2>
        <?php
        if (!empty($imagem)) {
            echo "<img src='./fotos/$imagem' alt='Imagem do usuário'>";
        } else {
            echo "Imagem não disponível";
        }

        echo "<br>";
        echo "Usuário: " . $row['email'] . "<br>";
        // Não exibiremos a senha aqui, pois não é uma prática segura
        // echo 'Senha: *********<br>';
        ?>
    </div>
</body>

</html>
