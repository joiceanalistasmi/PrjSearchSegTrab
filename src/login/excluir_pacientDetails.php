<?php
include("../../conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE p 
                FROM pacient_details AS p 
                JOIN 
                    agendamentos AS a ON p.fk_agenda = a.id 
                WHERE 
                    p.id = $id";
    mysqli_query($conexao, $query) or die("Erro ao excluir: " . mysqli_error($conexao));
}
// Redireciona de volta para a página de visualização com os filtros

$servidor_id = $_GET['servidor_id'] ?? '';  
header("Location: pacient_details.php?servidor_id=" . urlencode($servidor_id));


exit;
?>