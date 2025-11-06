<?php 
include("../../conexao.php"); 
session_start();

print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação básica
    if (empty($_POST['cid']) || empty($_POST['data_inicio']) || 
        empty($_POST['data_final']) || empty($_POST['tipo_servico']) || 
        empty($_POST['servidor_id'])) {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.'); window.history.back();</script>";
        exit;
    }

    var_dump($_POST);
    $cid = mysqli_real_escape_string($conexao, $_POST["cid"]);
    $data_inicio = mysqli_real_escape_string($conexao, $_POST["data_inicio"]);
    $data_final = mysqli_real_escape_string($conexao, $_POST["data_final"]);
    $tipo_servico = mysqli_real_escape_string($conexao, $_POST["tipo_servico"]);
    $observacao = mysqli_real_escape_string($conexao, $_POST["observacao"]);
    $servidor_id = mysqli_real_escape_string($conexao, $_POST["servidor_id"]);

    // INSERT 
    
    $sql = "INSERT INTO pacient_details 
            (cid, data_inicio, data_final, tipo_servico, observacao, fk_agenda)
            VALUES ('$cid','$data_inicio','$data_final','$tipo_servico','$observacao','$servidor_id')";

    if (mysqli_query($conexao, $sql)) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='pacient_details.php';</script>";
    } else {
        echo "<script>alert('Erro ao gravar: " . mysqli_error($conexao) . "'); window.history.back();</script>";
    }
}
?>