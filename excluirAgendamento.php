
<?php
include("conexao.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM agendamentos WHERE id = '$id'";
    mysqli_query($conexao, $query) or die("Erro ao excluir: " . mysqli_error($conexao));
}

// Redireciona de volta para a página de visualização com os filtros
$dataInicio = $_GET['dataInicio'] ?? '';
$dataFim = $_GET['dataFim'] ?? '';
$btnSearch = $_GET['btn-search'] ?? '';
header("Location: search_agendamentos.php?dataInicio=$dataInicio&dataFim=$dataFim&btn-search=$btnSearch");
exit;
?>
