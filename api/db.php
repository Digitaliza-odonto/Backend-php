<?php
function db($query) {
    $dbHost = 'localhost';
    $dbUser = 'id19623577_pedroaf0';
    $dbPass = '33551047pP';
    $dbName = 'id19623577_ufpel';

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