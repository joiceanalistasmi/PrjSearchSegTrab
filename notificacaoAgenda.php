<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
include("conexao.php");

// Recebe os dados do formulário
$email = $_POST['email'];
$id = $_POST['id'];
$nome = $_POST['nome'];
$data_agendamento = $_POST['data_agendamento'];
$horario = $_POST['horario'];

// Verifica se o e-mail e o id existem no banco
$sqlEnviarEmail = mysqli_query($conexao, "SELECT * FROM agendamentos WHERE email = '$email' AND id = '$id'");
if (mysqli_num_rows($sqlEnviarEmail) == 0) {
    echo "Usuário não encontrado ou dados incorretos.";
    exit;
}

$mail = new PHPMailer(true);

try {
    // Configurações do servidor
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'joice.smipm@gmail.com';
    $mail->Password   = 'hvw lynd jwkf';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom($mail->Username, 'Joice');
    $mail->addAddress($email, $nome);

    // Conteúdo
    $mail->isHTML(true);
    $mail->Subject = 'Notificação da Perícia médica - Prefeitura de São Miguel do Iguaçu';
    $mail->Body    = '<strong>O Usuário agendou um exame de Perícia médica para a ' . $data_agendamento . ' no horário: ' . $horario . '</strong>';
    $mail->AltBody = 'O Usuário agendou um exame de Perícia médica para a ' . $data_agendamento . ' no horário: ' . $horario;

    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
?>
