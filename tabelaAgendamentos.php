 <?php
    include("conexao.php");
    date_default_timezone_set('America/Sao_Paulo');

    $dataInicio = $_POST['dataInicio'] ?? '';
    $dataFim = $_POST['dataFim'] ?? '';

    if (!empty($dataInicio) && !empty($dataFim) && $dataInicio <= $dataFim) {
        $sql = mysqli_query($conexao, "SELECT * FROM agendamentos WHERE data_agendamento >= '$dataInicio' AND data_agendamento <= '$dataFim' ORDER BY data_agendamento DESC");
    } else {
        $hoje = date('Y-m-d');
        $sql = mysqli_query($conexao, "SELECT * FROM agendamentos WHERE data_agendamento = '$hoje' ORDER BY data_agendamento DESC");
    }

    if ($sql && mysqli_num_rows($sql) > 0) {
        echo "<table class='table table-striped' border='1'>
        <thead>
            <tr>
                <th>Nome do Servidor</th>
                <th>Tipo de Usuário</th>
                <th>E-mail</th>
                <th>Tipo de Atendimento</th>
                <th>Data do Agendamento</th>
                <th>Horário</th>
                <th>Status</th> 
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>";
        while ($row = mysqli_fetch_assoc($sql)) {
            $details = htmlspecialchars(json_encode([
                'Nome do Servidor' => $row['nome_servidor'],
                'Tipo de Usuário' => $row['tipo_de_usuario'],
                'E-mail' => $row['email'],
                'Tipo de Atendimento' => $row['tipo'],
                'Data do Agendamento' => $row['data_agendamento'],
                'Horário' => $row['horario'],
                'Status' => $row['status']
            ]), ENT_QUOTES, 'UTF-8');

            echo "<tr>
                <td>{$row['nome_servidor']}</td>
                <td>{$row['tipo_de_usuario']}</td>
                <td>{$row['email']}</td>
                <td>{$row['tipo']}</td>
                <td>{$row['data_agendamento']}</td>
                <td>{$row['horario']}</td>
                <td>{$row['status']}</td>
                <td>
                    <button class='btn btn-info visualizar-btn' data-details='$details'><i class='bi bi-eye'></i></button>
                    <a href='editarAgendamento.php?id={$row['id']}' class='btn btn-primary'><i class='bi bi-pencil'></i></a>
                    <a href='excluirAgendamento.php?id={$row['id']}' class='btn btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir este agendamento?');\"><i class='bi bi-x'></i></a>
                </td>
            </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>Nenhum agendamento encontrado, verifique as datas.</p>";
    }
    ?>
