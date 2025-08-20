<?php
include("conexao.php");
session_start();
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html lang='pt-BR'>

<head>
    <meta charset='UTF-8' name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Agendamentos</title>
    <link rel='stylesheet' href='style.css'>
    <link rel='stylesheet' href="responsive.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="funcao.js"></script>
</head> 

<body>
    <header>
        <img src="imagens/logo1.jpg" alt="Logo" class="logo">
        <div> <img src="imagens/prefeitura.jpg" alt="Prefeitura de São Miguel do Iguaçu">
        </div>
    </header>

    <section>
        <h2 class="titulo-centralizado">Visualizar agendamentos de Perícia Médica - Segurança do Trabalho</h2>
        <br>
       
        <form method="POST" action="" id="searchAgendamento">
            <div class="mb-3">
                <button type="button" class="btn btn-primary" onclick="window.location.href='agendamento.php'">NOVO AGENDAMENTO</button>
            </div> <br>
            <div class="mb-3">
                <label for="search_agendamento" class="form-label">Pesquisar Agendamentos:</label>
                <br>
                <label for="search_agendamento" class="form-label">Data(Inicial e Final)</label>
                <input type="date" class="form-control" id="dataInicio" name="dataInicio" style=" width: 20%;">
                <span>até</span>
                <input type="date" class="form-control" id="dataFim" name="dataFim" style=" width: 20%;">

                <button type="submit" class="btn btn-primary" name="btn-search" id="btn-search">CONSULTAR</button>
            </div> <br>
        </form>
        <?php
        if (isset($_POST['btn-search']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $dataInicio  = $_POST['dataInicio'];
            $dataFim     = $_POST['dataFim'];
            // datas preenchidas com início <= fim
            if (!empty($dataInicio) && !empty($dataFim)) {
                if ($dataInicio <= $dataFim) {
                    $sqlVisualizarAgendamentos =
                        mysqli_query($conexao, "SELECT * FROM agendamentos WHERE data_agendamento >= '$dataInicio' AND data_agendamento <= '$dataFim' 
                ORDER BY data_agendamento DESC") or die("Erro ao consultar agendamentos. " . mysqli_error($conexao));
                } else {
                    echo "<script>alert('A data de início não pode ser maior que a data de fim.');</script>";
                    $sqlVisualizarAgendamentos = false;
                }
            } else {
                // data atual
                $hoje = new DateTime();
                $hoje = $hoje->format('Y-m-d');
                $sqlVisualizarAgendamentos = mysqli_query($conexao, "SELECT * FROM agendamentos  WHERE data_agendamento = '$hoje' ORDER BY data_agendamento DESC")
                    or die("Erro ao consultar agendamentos. " . mysqli_error($conexao));
            }

            if ($sqlVisualizarAgendamentos && mysqli_num_rows($sqlVisualizarAgendamentos) > 0) {
                echo "<table class='table table-striped' border='1'>";
                echo "<thead>
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
            </thead>";
                echo "<tbody>";
                while ($row = mysqli_fetch_assoc($sqlVisualizarAgendamentos)) {
                    $details = htmlspecialchars(json_encode([
                        'Nome do Servidor' => $row['nome_servidor'],
                        'Tipo de Usuário' => $row['tipo_de_usuario'],
                        'E-mail' => $row['email'],
                        'Tipo de Atendimento' => $row['tipo'],
                        'Data do Agendamento' => $row['data_agendamento'],
                        'Horário' => $row['horario'],
                        'Status' => $row['status']
                    ]), ENT_QUOTES, 'UTF-8');
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nome_servidor']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tipo_de_usuario']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['data_agendamento']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['horario']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>
                    <button type='button' class='btn btn-info visualizar-btn' data-details='$details'>
                    <i class='bi bi-eye'></i> </button> <!-- visualizar -->

                    <a href='editarAgendamento.php?id=" . $row['id'] . "' class='btn btn-primary'>
                    <i class='bi bi-pencil'></i> </a> <!-- editar -->
                    <a href='excluirAgendamento.php?id=" . $row['id'] . "&dataInicio=$dataInicio&dataFim=$dataFim&btn-search=CONSULTAR' 
                    class='btn btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir este agendamento?');\">
                    <i class='bi bi-x'></i><!-- excluir -->
                    </a>
                </td>";

                    echo "</tr>";
                }


                echo "</tbody>";
                echo "</table>";
            } elseif ($sqlVisualizarAgendamentos) {
                echo "<p>Nenhum agendamento encontrado.</p>";
            }
        }
        ?>

        <!-- Modal HTML -->
        <div id="detalheModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="close" id="fecharModal">&times;</span>
                <h3>Detalhes do Agendamento</h3>
                <div id="modalDetalhes"></div>
            </div>
        </div>
    </section>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Prefeitura de São Miguel do Iguaçu - Todos os direitos reservados.</p>
    </footer>
</body>

</html>
<script>
    // funcao para o modal 
    window.onload = function() {
        document.querySelectorAll('.visualizar-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var details = JSON.parse(this.getAttribute('data-details'));
                var html = '';
                for (var key in details) {
                    html += '<p><strong>' + key + ':</strong> ' + details[key] + '</p>';
                }
                document.getElementById('modalDetalhes').innerHTML = html;
                document.getElementById('detalheModal').style.display = 'block';
            });
        });

        document.getElementById('fecharModal').onclick = function() {
            document.getElementById('detalheModal').style.display = 'none';
        };

        window.onclick = function(event) {
            var modal = document.getElementById('detalheModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    };

    //cls no Historico para voltar 
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }


    document.getElementsByTagName(atualizarPagina, 3000); // Chama a função a cada 5 segundos
</script>