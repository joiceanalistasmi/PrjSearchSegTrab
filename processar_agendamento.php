<?php
 
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once 'funcoesPhp.php';
include("conexao.php");

session_start();

if (
    isset($_POST['nome_servidor']) && isset($_POST['telefone']) && isset($_POST['tipo']) && isset($_POST['tipo_de_usuario'])
) {

    $nome_servidor = htmlspecialchars($_POST["nome_servidor"]);
    $tipo_de_usuario = htmlspecialchars($_POST["tipo_de_usuario"]);
    $nome_acompanhante = $_POST["nome_acompanhante"];
    $email = filter_var($_POST["email"]);
    $tipo = htmlspecialchars($_POST["tipo"]); //se é consulta ou atestado
    $telefone = htmlspecialchars($_POST["telefone"]);
    $data_agendamento = htmlspecialchars($_POST["data_agendamento"]);
    $horario = htmlspecialchars($_POST["horario"]); 
    $status = $_POST["status"];

    if (
        empty($nome_servidor) || empty($tipo_de_usuario) || empty($telefone) || empty($tipo) ||
        empty($data_agendamento) || empty($horario) 
    ) {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.history.back();</script>";
        exit;
    } else {
        $sqlconsultahoraDisponivel =
            mysqli_query(
                $conexao,
                "SELECT * FROM agendamentos WHERE horario = '$horario' AND data_agendamento = '$data_agendamento'"
            ) or die("Erro ao consultar horários disponíveis. " . mysqli_error($conexao));

        if (mysqli_num_rows($sqlconsultahoraDisponivel) > 0) {
            echo "<script>alert('Horário já agendado. Por favor, escolha outro horário.'); window.history.back();</script>";
            exit;
        } else {
            $sqlGravarAgenda = mysqli_query(
                $conexao,
                "INSERT INTO agendamentos (nome_servidor, tipo_de_usuario, nome_acompanhante, telefone, email, tipo, data_agendamento, horario, status)
                VALUES ('$nome_servidor','$tipo_de_usuario','$nome_acompanhante', '$telefone', '$email','$tipo','$data_agendamento', '$horario', '$status')"
            ) or die("Erro ao gravar o registro. " . mysqli_error($conexao));

            $resultadoEmail = enviarNotificacao($nome_servidor, $tipo_de_usuario, $email, $telefone, $tipo, $data_agendamento, $horario);
            if ($resultadoEmail === true) {
                echo "<script>alert('Registro gravado e e-mail enviado com sucesso!'); window.location.href = 'https://saomiguel.pr.gov.br/';</script>";
            } else {
                echo "<script>alert('Registro gravado, mas houve erro ao enviar o email de Notificação'); window.location.href = 'agendamento.php';</script>";
            }
            exit;
        }
    }
} else {
    echo "<script>alert('Dados não recebidos corretamente.'); window.history.back();</script>";
    exit;
    session_destroy();
}

 
//enviar a notitificação por e-mail
include("notificacaoAgenda.php");
$sqlnotificaUsuaruio = mysqli_query(
    $conexao,
    "INSERT INTO notificacoes (agendamento_id, tipo, data_envio) VALUES ('$id', '$tipo', NOW())"
);


?>