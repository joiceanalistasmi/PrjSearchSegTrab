<?php 
include("../../conexao.php"); 
session_start();

function save() { 
    include("../../conexao.php"); 

  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação básica
    if (empty($_POST['cid']) || empty($_POST['data_inicio']) || 
        empty($_POST['data_final']) || empty($_POST['tipo_servico']) || 
        empty($_POST['servidor_id'])) {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.'); window.history.back();</script>";
        exit;
    }
 
   // var_dump($_POST);
    $servidor_id = (int) $_POST['servidor_id'];
    $cid = mysqli_real_escape_string($conexao, $_POST["cid"]);
    $data_inicio = mysqli_real_escape_string($conexao, $_POST["data_inicio"]);
    $data_final = mysqli_real_escape_string($conexao, $_POST["data_final"]);
    $tipo_servico = mysqli_real_escape_string($conexao, $_POST["tipo_servico"]);
    $observacao = mysqli_real_escape_string($conexao, $_POST["observacao"]);
    $servidor_id = mysqli_real_escape_string($conexao, $_POST["servidor_id"]);

    //
    $servidor_nome = mysqli_real_escape_string($conexao, $_POST["servidor"]);
    $nome_url = urlencode($servidor_nome);

    // INSERT  
    $sql = "INSERT INTO pacient_details 
            (cid, data_inicio, data_final, tipo_servico, observacao, fk_agenda)
            VALUES ('$cid','$data_inicio','$data_final','$tipo_servico','$observacao','$servidor_id')";
    //manter o codigo do paciente vinculado 
   if (mysqli_query($conexao, $sql)) {
    echo json_encode([
        "status" => "ok",
        "mensagem" => "Cadastro realizado com sucesso!",
        "redirect" => "pacient_details.php?servidor_id=$servidor_id&servidor_nome=$nome_url"
        ]);
    } else {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Erro ao gravar: " . mysqli_error($conexao)
        ]);
    }

}
}

if (isset($_POST['action'])) {
    if ($_POST['action'] === 'save') { 
        save();
    } else {
        echo "Ação desconhecida!";
    }
} else {
    echo "Nenhuma ação informada!";
}

function edit($servidor_id) {
    include("../../conexao.php"); 
    // Função de edição (se necessário)
    if (isset($_POST['id'])) {
        $id = (int) $_POST['id'];
        if ($id <= 0) {
            echo "<script>alert('ID inválido.'); window.history.back();</script>";
            exit;
        }else{
            $cid = mysqli_real_escape_string($conexao, $_POST["cid"]);
            $data_inicio = mysqli_real_escape_string($conexao, $_POST["data_inicio"]);
            $data_final = mysqli_real_escape_string($conexao, $_POST["data_final"]);
            $tipo_servico = mysqli_real_escape_string($conexao, $_POST["tipo_servico"]);
            $observacao = mysqli_real_escape_string($conexao, $_POST["observacao"]);
            $sql = "UPDATE pacient_details SET 
                    cid='$cid', 
                    data_inicio='$data_inicio', 
                    data_final='$data_final', 
                    tipo_servico='$tipo_servico', 
                    observacao='$observacao' 
                    WHERE id=$id";

        }
        if (mysqli_query($conexao, $sql)) {
            echo "<script>alert('Atualização realizada com sucesso!'); 
             window.location.href = 'pacient_details.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar: " . mysqli_error($conexao) . "'); window.history.back();</script>";
        }
    }
}



?>