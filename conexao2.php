<?php
// Configurações do servidor, banco de dados, usuario e senha
// onde o PHP vai se conectar
$servidor='localhost';
$db = "login2";
$user = 'root';
$pass = ''; 
//$pass = 'usbw'; // senha para o usbwebserver
try {
  // $conn - é a variável que irá receber
  // os dados da conexão ao Banco de dados
  // No caso do exemplo um servidor MySQL
  $conn = new PDO('mysql:host='.$servidor.';dbname='.$db ,  $user, $pass);
  //echo "Conectado com sucesso!!!";

  // Testa um erro de exception na classe PDO
  // Classe responsável pela conexão ao banco
  //  de dados
} catch (PDOException $e) {
  // Mostra mensagem do erro ocorrido
    echo 'Erro número : ' . $e->getMessage();
}
?>