<?php
include("conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pacient_details WHERE id = '$id'";
    mysqli_query($conexao, $query) or die("Erro ao excluir: " . mysqli_error($conexao));
}

exit;
?>