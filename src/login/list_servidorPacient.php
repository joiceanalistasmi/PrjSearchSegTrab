<?php
include("../../conexao.php");

if (isset($_POST['nome_servidor'])) {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome_servidor']);

    $sql = "SELECT DISTINCT nome_servidor FROM agendamentos 
            WHERE nome_servidor LIKE '%$nome%' 
            ORDER BY nome_servidor ASC LIMIT 15";
    $res = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($res) > 0) {
        echo "<ul class='list-group'>";
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<li class='list-group-item servidor-item' style='cursor:pointer;'>"
               . htmlspecialchars($row['nome_servidor']) .
               "<a href='Selecionar.php?id={$row['id']}' class='btn btn-primary'>
               <i class='bi bi-pencil' ></i> + </a>".
               "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='text-center text-muted'>Nenhum servidor encontrado.</p>";
    }
}
?>
