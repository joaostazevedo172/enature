

<!DOCTYPE html>

<html lang="en">

 

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="style.css">

    <style>

        body {

            margin: 0;

            padding: 0;

            font-family: Arial, sans-serif;

            background-image: url('natu.png');

            /* Caminho para a imagem de fundo */

            background-size: cover;

            background-position: center;

            background-attachment: fixed;

 

        }

 

        .card-front {

            background-color: #c0c0c0;

            /* Cor de fundo cinza claro */

        }

 

        .card-back {

            background-color: #c0c0c0;

            /* Cor de fundo cinza claro */

        }

 

        /* Altera a fonte da escrita "Login" */

        h3 {

            color: black;

            ;

        }

 

        /* Altera a cor do botão "Submit" */

        .btn {

            background-color: #434447a8;

            ;

            color: black;

            /* Substitua #suaCorDesejada pela cor desejada em formato hexadecimal ou nome da cor */

            /* ... outras propriedades CSS ... */

        }

 

        .btn:hover {

            background-color: black;

            /* Substitua #suaCorHover pela cor desejada em formato hexadecimal ou nome da cor */

            color: white;

            /* Substitua #suaCorTextoHover pela cor desejada do texto em formato hexadecimal ou nome da cor */

            /* ... outras propriedades CSS de hover ... */

        }

 

        /* Altera a cor do ícone do botão de transição quando marcado */

        .checkbox:checked+label:before {

            background-color: black;

            /* Substitua #suaCor pela cor desejada em formato hexadecimal ou nome da cor */

            color: white;

            /* Substitua #suaCorTexto pela cor desejada do ícone em formato hexadecimal ou nome da cor */

            /* ... outras propriedades CSS ... */

        }

 

        /* Altera a cor do ícone do botão de transição do Log In para Sign Up quando não está marcado */

        .checkbox:not(:checked)+label:before {

            background-color: black;

            /* Substitua #suaCor pela cor desejada em formato hexadecimal ou nome da cor */

            color: white;

            /* Substitua #suaCorTexto pela cor desejada do ícone em formato hexadecimal ou nome da cor */

            /* ... outras propriedades CSS ... */

        }

 

       

       

    </style>

</head>

 

<body>

    <div class="section full-height">

        <div class="container">

            <div class="row full-height justify-content-center">

                <div class="col-12 text-center align-self-center py-5">

 

                    <div class="section pb-5 pt-5 pt-sm-2 text-center">

                        <h6 class="mb-0 pb-3"><span></span><span></span></h6>

                        <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />

                        <label for="reg-log"></label>

                        <div class="card-3d-wrap mx-auto">

                            <div class="card-3d-wrapper">

                                <div class="card-front">

                                    <div class="center-wrap">

                                        <div class="section text-center">

                                            <h3 class="mb-4 pb-3">Log In</h3>

                                            <form method="POST" action="index.php">

                                                <div class="form-group">

                                                    <input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">

                                                    <i class="input-icon uil uil-at"></i>

                                                </div>

                                                <br>

                                                <div class="form-group mt-2">

                                                    <input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">

                                                    <i class="input-icon uil uil-lock-alt"></i>

                                                </div>

                                                <br>

                                                <button type="submit" class="btn mt-4" name="loginSubmit">Submit</button>

                                            </form>

                                            <?php

                                            include 'conexao2.php';

 

                                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginSubmit'])) {

                                                if (isset($_POST['logemail']) && isset($_POST['logpass'])) {

                                                    $email = $_POST['logemail'];

                                                    $senha = $_POST['logpass'];

 

                                                    $query = "SELECT * FROM estilo WHERE email = ?";

                                                    $stmt = $conn->prepare($query);

                                                    $stmt->execute([$email]);

 

                                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                    if ($result && password_verify($senha, $result['senha'])) {

                                                        // Login efetuado com sucesso


                                                        // Redirecionar para index.html na pasta different

                                                        echo '<script>window.location.href = "history.html";</script>';

                                                    } else {

                                                        echo '<script>alert("Senha Inválida.");</script>';

                                                    }

                                                }

                                            }

 

                                            ?>

                                        </div>

                                    </div>

                                </div>

                                <div class="card-back">

                                    <div class="center-wrap">

                                        <div class="section text-center">

                                            <h3 class="mb-4 pb-3">Sign Up</h3>

                                            <form method="POST" action="index.php">

                                                <div class="form-group">

                                                    <input type="text" name="logname" class="form-style" placeholder="Your Full Name" id="logname" autocomplete="off">

                                                    <i class="input-icon uil uil-user"></i>

                                                </div>

                                                <br>

                                                <div class="form-group mt-2">

                                                    <input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">

                                                    <i class="input-icon uil uil-at"></i>

                                                </div>

                                                <br>

                                                <div class="form-group mt-2">

                                                    <input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">

                                                    <i class="input-icon uil uil-lock-alt"></i>

                                                </div>

                                                <br>

                                                <button type="submit" class="btn mt-4" name="signupSubmit">Submit</button>

                                            </form>

                                            <?php

                                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signupSubmit'])) {

                                                if (isset($_POST['logname']) && isset($_POST['logemail']) && isset($_POST['logpass'])) {

                                                    $nome = $_POST['logname'];

                                                    $email = $_POST['logemail'];

                                                    $senha = password_hash($_POST['logpass'], PASSWORD_DEFAULT);

 

                                                    // Verifica se o email já está cadastrado

                                                    $checkQuery = "SELECT * FROM estilo WHERE email = ?";

                                                    $checkStmt = $conn->prepare($checkQuery);

                                                    $checkStmt->execute([$email]);

                                                    $existingUser = $checkStmt->fetch(PDO::FETCH_ASSOC);

 

                                                    if (!$existingUser) {

                                                        $insertQuery = "INSERT INTO estilo (nome, email, senha) VALUES (?, ?, ?)";

                                                        $insertStmt = $conn->prepare($insertQuery);

                                                        if ($insertStmt->execute([$nome, $email, $senha])) {

                                                            echo '<script>alert("Registro inserido com sucesso.");</script>';

                                                        }

                                                    } else {

                                                        echo '<script>alert("Esse email já foi cadastrado.");</script>';

                                                    }

                                                }

                                            }

                                            ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

 

    <!-- ... corpo do HTML ... -->

</body>

 

</html>



 