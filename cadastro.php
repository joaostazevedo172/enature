<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Formulário</title>
<link rel="stylesheet" href="./estilos.css">
<style>
       /* Estilizando o botão "Escolher Arquivo" */
       .custom-file-input {
           display: none;
       }

       .custom-file-label {
           background-color: #333;
           color: #fff;
           padding: 10px 20px;
           border-radius: 5px;
           cursor: pointer;
           transition: background-color 0.3s ease;
           display: inline-block;
       }

       .custom-file-label:hover {
           background-color: #555;
       }

       /* Estilizando o botão "Salvar" */
       .custom-submit-button {
           background-color: #333;
           color: #fff;
           padding: 10px 20px;
           border: none;
           border-radius: 5px;
           cursor: pointer;
           transition: background-color 0.3s ease;
           font-size: 16px;
           display: inline-block;
       }

       .custom-submit-button:hover {
           background-color: #555;
       }

       /* Estilos para as mensagens de feedback */
       .mensagem {
           margin-top: 20px;
           padding: 10px;
           font-size: 18px;
           text-align: center;
       }

       .sucesso {
           color: green;
           font-weight: bold;
       }

       .erro {
           color: red;
           font-weight: bold;
       }
</style>
</head>

<body>
<div class="mensagem">
    <?php
    $mensagem = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email']) && isset($_POST['senha'])) {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            if (empty($email) || empty($senha)) {
                $mensagem = 'Campos não podem ser vazios!';
            } else {
                // Verifica se o usuário já existe no banco de dados
                include "conexao2.php";
                try {
                    $verificarUsuario = $conn->prepare('SELECT * FROM estilo WHERE email = :email');
                    $verificarUsuario->execute(array(':email' => $email));
                    if ($verificarUsuario->rowCount() > 0) {
                        // O usuário já existe
                        $mensagem = '<span class="erro">Usuário já existe!</span>';
                    } else {
                        // O usuário não existe, então é inserido no banco de dados
                        $dir = './fotos/';
                        $tmpName = $_FILES['arquivo']['tmp_name'];
                        $name = $_FILES['arquivo']['name'];

                        if (move_uploaded_file($tmpName, $dir . $name)) {
                            // Criptografa a senha antes de inserir no banco de dados
                            $senhaCript = password_hash($senha, PASSWORD_DEFAULT);

                            // Restante do seu código para inserir o usuário no banco de dados
                            include "conexao2.php";
                            try {
                                $estilo = $conn->prepare('INSERT INTO estilo (email, senha, foto) VALUES (:email, :senha, :foto)');
                                $estilo->execute(array(
                                    ':email' => $email,
                                    ':senha' => $senhaCript,
                                    ':foto' => $name,
                                ));

                                if ($estilo->rowCount() == 1) {
                                    $mensagem = '<span class="sucesso">Incluído com sucesso!</span>';
                                } else {
                                    $mensagem = '<span class="erro">Erro ao incluir!</span>';
                                }
                            } catch (PDOException $e) {
                                $mensagem = 'ERROR: ' . $e->getMessage();
                            }
                        } else {
                            $mensagem = '<span class="erro">Erro ao gravar o arquivo!</span>';
                        }
                    }
                } catch (PDOException $e) {
                    $mensagem = 'ERROR: ' . $e->getMessage();
                }
            }
        }
    }
    ?>

    <!-- Exibe a mensagem de feedback -->
    <?php if (!empty($mensagem)) { ?>
        <p class="<?php echo ($mensagem === 'Usuário já existe!' || $mensagem === 'Incluído com sucesso!') ? 'sucesso' : 'erro'; ?>"><?php echo $mensagem; ?></p>
    <?php } ?>
</div>

<div class="caixa__login">
    <h2>Cadastro</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="caixa__login-input">
            <input type="text" required name="email" />
            <label>Usuário ou Email</label>
        </div>
        <div class="caixa__login-input">
            <input type="password" required name="senha" />
            <label>Senha</label>
        </div>
        <div>
            <label for="arquivo" class="custom-file-label">Escolher Arquivo</label>
            <input type="file" required name="arquivo" id="arquivo" class="custom-file-input" />
        </div>
        <br>
        <br>
        <div class="botoes">
            <input type="submit" required value="Salvar" class="custom-submit-button" />
            <a href="login.php" class="custom-submit-button">Voltar para o Login</a>
        </div>
    </form>
</div>

</body>

</html>
