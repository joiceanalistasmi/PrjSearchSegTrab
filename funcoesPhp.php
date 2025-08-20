<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
include("conexao.php");


function enviarNotificacao($nome_servidor, $tipo_de_usuario, $email, $telefone, $tipo, $data_agendamento, $horario)
{
    $mail = new PHPMailer(true);
    try {
        // conf do servidor 
        //preciso verificar pois aqui esta o meu email 
         
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'joice.analistasmi@gmail.com'; //modificar
        $mail->Password   = 'naxk bdsi scla dtfj';// senha criada google 
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom($mail->Username, 'Joice');
        $mail->addAddress($email, $nome_servidor);

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = 'Notificação da Perícia médica - Prefeitura de São Miguel do Iguaçu';
        $mail->Body    = '<strong> O ' .$nome_servidor. ' agendou uma consulta para a data: ' . $data_agendamento . ' as ' . $horario . '</strong>';
        $mail->AltBody = ' O ' .$nome_servidor. '  agendou uma consulta para a ' . $data_agendamento . ' as ' . $horario;
        
       // $mail->SMTPDebug = 2; 
       // $mail->Debugoutput = 'html';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}


?>