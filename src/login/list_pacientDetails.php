<?php
include("../../conexao.php");
date_default_timezone_set('America/Sao_Paulo');

$servidor = $_POST['servidor'] ?? '';

if (empty($servidor)) {
    echo "<p>Nenhum servidor selecionado.</p>";
    exit;
}

$sql = mysqli_query($conexao, "
    SELECT 
        p.nome_servidor,
        p.cid,
        a.data_inicio,
        a.data_fim,
        a.tipo_atendimento,
        a.observacao,
        a.status,
        a.id
    FROM 
        pacient_details AS p
        INNER JOIN agendamentos AS a ON p.id_agendamento = a.id
    WHERE 
        p.nome_servidor LIKE '%$servidor%'
    ORDER BY 
        a.data_agendamento DESC
");

if ($sql && mysqli_num_rows($sql) > 0) {
    echo "<h4>Procedimentos de <strong>$servidor</strong></h4>";
    echo "<table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>CID</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th>Tipo de Atendimento</th>
                    <th>Observação</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_assoc($sql)) {
        echo "<tr>
                <td>{$row['cid']}</td>
                <td>{$row['data_inicio']}</td>
                <td>{$row['data_fim']}</td>
                <td>{$row['tipo_atendimento']}</td>
                <td>{$row['observacao']}</td>
                <td>{$row['status']}</td>
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
