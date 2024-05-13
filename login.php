<?php
session_start(); // Inicia a sessão para usar variáveis de sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=login", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para obter o registro do usuário usando o email fornecido
        $query = $conn->prepare("SELECT * FROM estilo WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();

        if ($query->rowCount() == 1) {
            // Obtém os dados do usuário (incluindo senha criptografada)
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $senhaCriptografada = $row['senha'];

            // Verifica se a senha digitada corresponde à senha criptografada no banco
            if (password_verify($senha, $senhaCriptografada)) {
                // Senha correta, o usuário está logado com sucesso
                // Salvar o ID do usuário na sessão para uso posterior
                $_SESSION['user_id'] = $row['id'];
                // Redirecionar para a página de dados.php
                header('Location: dados.php');
                exit(); // Certifique-se de usar exit() para interromper a execução do script após o redirecionamento.
            } else {
                // Senha incorreta, armazena a mensagem de erro na variável de sessão
                $_SESSION['login_error'] = true;
                header('Location: login.php');
                exit(); // Redireciona de volta para a página de login
            }
        } else {
            // Email não encontrado, armazena a mensagem de erro na variável de sessão
            $_SESSION['login_error'] = true;
            header('Location: login.php');
            exit(); // Redireciona de volta para a página de login
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .caixa__login-buttons input[type="submit"],
        .caixa__login-buttons input[type="button"] {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-right: 10px;
            transition: background-color 0.5s ease;
        }

        .caixa__login-buttons input[type="submit"]:hover,
        .caixa__login-buttons input[type="button"]:hover {
            background-color: #666;
        }

        /* Estilização da mensagem de erro */
        .erro {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <form method="post" action="login.php">
        <div class="caixa__login">
            <h2>Login</h2>
            <div class="caixa__login-input">
                <input type="text" required name="email" />
                <label>Usuário ou Email</label>
            </div>
            <div class="caixa__login-input">
                <input type="password" required name="senha" />
                <label>Senha</label>
            </div>
            <div class="caixa__login-buttons">
                <input type="submit" value="Enviar" />
                <a href="cadastro.php"><input type="button" value="Cadastrar" /></a>
            </div>
            <?php
            // Exibe a mensagem de erro, se houver
            if (isset($_SESSION['login_error']) && $_SESSION['login_error']) {
                echo '<p class="erro">Usuário ou senha incorretos. Tente novamente.</p>';
                // Limpa a variável de sessão de erro para que a mensagem não apareça novamente após o refresh
                $_SESSION['login_error'] = false;
            }
            ?>
        </div>
    </form>
</body>

</html>
