<?php
function db($query) {
    $dbHost = 'seu_host';
    $dbUser = 'seu_usuario';
    $dbPass = 'sua_senha';
    $dbName = 'seu_banco_de_dados';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Erro de conexão com o banco de dados: " . $conn->connect_error);
    }

    $result = $conn->query($query);

    if (!$result) {
        die("Erro na consulta: " . $conn->error);
    }

    $conn->close();

    return $result;
}
?>