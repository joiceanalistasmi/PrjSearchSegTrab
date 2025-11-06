<?php
include("../../conexao.php");
date_default_timezone_set('America/Sao_Paulo');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_POST['servidor_id'])) {
    echo "<p>Nenhum servidor selecionado.</p>";
    exit;
}

$servidor_id = (int) $_POST['servidor_id'];

$sql = mysqli_query($conexao, "
    SELECT 
        a.nome_servidor,
        p.cid,
        p.data_inicio,
        p.data_final,
        p.tipo_servico,
        p.observacao,
        a.id
    FROM 
        pacient_details AS p
        INNER JOIN agendamentos AS a ON p.fk_agenda = a.id
    WHERE 
        a.id = $servidor_id
    ORDER BY 
        p.data_inicio desc
");

if (mysqli_num_rows($sql) > 0) {
    $dados = mysqli_fetch_assoc($sql);
    echo "<h4>Procedimentos de <strong>" . htmlspecialchars($dados['nome_servidor']) . "</strong></h4>";

    mysqli_data_seek($sql, 0); // Volta o ponteiro para o início

    echo "<table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>CID</th>
                    <th>Data Início</th>
                    <th>Data Final</th>
                    <th>Tipo de Serviço</th>
                    <th>Observação</th> 
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_assoc($sql)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['cid']) . "</td>
                <td>" . htmlspecialchars($row['data_inicio']) . "</td>
                <td>" . htmlspecialchars($row['data_final']) . "</td>
                <td>" . htmlspecialchars($row['tipo_servico']) . "</td>
                <td>" . htmlspecialchars($row['observacao']) . "</td>
                <td>
                    <a href='editarAgendamento.php?id={$row['id']}' class='btn btn-primary btn-sm'>Editar</a>
                    <a href='excluirAgendamento.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Tem certeza que deseja excluir este prontuário?');\">Excluir</a>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p>Nenhum procedimento encontrado para este servidor.</p>";
}
?>
