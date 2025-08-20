<?php

$host = 'localhost';
$database = 'agenda_seguranca';
$user = 'root';
$password = '12345678';


$conexao = new mysqli($host, $user, $password, $database);

if ($conexao->connect_error) {
    die("ConexÃ£o falhou: " . $conexao->connect_error);
}

$conexao->set_charset("utf8");
?>