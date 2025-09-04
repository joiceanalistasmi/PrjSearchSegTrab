<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendamento para perícia médica - Segurança do trabalho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    <script src="funcao.js"></script>

</head>

<body>
    <header>
        <img src="imagens/logo1.jpg" alt="Logo" class="logo">
        <div>
            <img src="imagens/prefeitura.jpg" alt="Prefeitura de São Miguel do Iguaçu">
        </div>
    </header>
    <section>
        <div>
            <?php
            include("conexao.php");
            require 'funcoesPhp.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-gravar'])) {
                $id = intval($_POST['id']);
                $nome_servidor = $_POST['nome_servidor'];
                $tipo_de_usuario = $_POST['tipo_de_usuario'];
                $nome_acompanhante = $_POST['nome_acompanhante'];
                $email = $_POST['email'];
                $telefone = $_POST['telefone'];
                $tipo = $_POST['tipo'];
                $data_agendamento = $_POST['data_agendamento'];
                $horario = $_POST['horario'];
                $status = $_POST['status'];

                $sqlEditar = "UPDATE agendamentos SET 
                                nome_servidor = '$nome_servidor',
                                tipo_de_usuario = '$tipo_de_usuario',
                                nome_acompanhante = '$nome_acompanhante',
                                email = '$email',
                                telefone = '$telefone',
                                tipo = '$tipo',
                                data_agendamento = '$data_agendamento', 
                                horario = '$horario',
                                status = '$status' 
                                WHERE id = $id";

                //envia notificação por e-mail
                $resultadoEmail = enviarNotificacao($nome_servidor, $tipo_de_usuario, $email, $telefone, $tipo, $data_agendamento, $horario);
                if ($resultadoEmail !== true) {
                    echo "<script>alert('Erro ao enviar e-mail: $resultadoEmail');</script>";
                }

                if (mysqli_query($conexao, $sqlEditar)) {
                    echo "<script>alert('Agendamento atualizado com sucesso!'); 
                                              window.location.href='index.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Erro ao atualizar agendamento.'); 
                                              window.history.back();</script>";
                    exit;
                }
            }

            // Exibe o formulário de edição
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $sql = mysqli_query($conexao, "SELECT * FROM agendamentos WHERE id = $id");
                if (mysqli_num_rows($sql) > 0) {
                    $agendamento = mysqli_fetch_assoc($sql);
            ?>
                    <form class="cadastro" action="editarAgendamento.php?id=<?php echo $id; ?>" name="formAgenda" id="formAgenda" method="POST">
                        <h4><b>Editar:</b> Agendamento - Perícia médica - Segurança do trabalho</h4>
                        <input type="hidden" name="id" value="<?php echo $agendamento['id']; ?>">
                        <div>
                            <label for="nome_servidor">Nome do Servidor</label>
                            <input type="text" id="nome_servidor" name="nome_servidor" value="<?php echo htmlspecialchars($agendamento['nome_servidor']); ?>" maxlength="100" required>
                        </div>
                        <div>
                            <label for="tipo_de_usuario">Tipo de Usuário</label>
                            <select id="tipo_de_usuario" name="tipo_de_usuario" required>
                                <option value="servidorPublico" <?php echo ($agendamento['tipo_de_usuario'] == 'servidorPublico') ? 'selected' : ''; ?>>Servidor público</option>
                                <option value="acompanhante" <?php echo ($agendamento['tipo_de_usuario'] == 'acompanhante') ? 'selected' : ''; ?>>Acompanhante</option>
                            </select>
                        </div>
                        <div>
                            <label for="nome_acompanhante">Nome do Acompanhante (quando necessario)</label>
                            <input type="text" id="nome_acompanhante" name="nome_acompanhante"
                                value="<?php echo htmlspecialchars($agendamento['nome_acompanhante']); ?>" maxlength="100">
                        </div>

                        <div>
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($agendamento['email']); ?>"
                                maxlength="100" onchange="mascaraEmail(this.value)">
                        </div>
                        <div>
                            <label for="telefone">Telefone*</label>
                            <input type="tel" id="telefone" name="telefone"
                                value="<?php echo htmlspecialchars($agendamento['telefone']); ?>" maxlength="14">

                        </div>
                        <div>
                            <label for="tipo">Tipo de Atendimento</label>
                            <select id="tipo" name="tipo" class="form-select" required>
                                <option value="consulta" <?php echo ($agendamento['tipo'] == 'consulta') ? 'selected' : ''; ?>>Retorno ao Trabalho</option>
                                <option value="Homologacao_de_Atestado" <?php echo ($agendamento['tipo'] == 'atestado') ? 'selected' : ''; ?>>Homologação de Atestado</option>
                            </select>
                        </div>
                        <div>
                            <label for="data_agendamento">Data do Agendamento</label>
                            <input type="date" id="data_agendamento" name="data_agendamento"
                                value="<?php echo htmlspecialchars($agendamento['data_agendamento']);  ?>" required>
                        </div>

                        <div>
                            <label for="horario">Horário</label>
                            <select id="horario" name="horario" required>
                                <option value="<?php echo $agendamento['horario']; ?>" selected>
                                    <?php echo $agendamento['horario']; ?>
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="pendente" <?php echo ($agendamento['status'] == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                                <option value="confirmado" <?php echo ($agendamento['status'] == 'confirmado') ? 'selected' : ''; ?>>Confirmado</option>
                                <option value="cancelado" <?php echo ($agendamento['status'] == 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                                <option value="reagendado" <?php echo ($agendamento['status'] == 'reagendado') ? 'selected' : ''; ?>>Reagendado</option>
                                <option value="em_atendimento" <?php echo ($agendamento['status'] == 'em_atendimento') ? 'selected' : ''; ?>>Em atendimento</option>
                                <option value="finalizado" <?php echo ($agendamento['status'] == 'finalizado') ? 'selected' : ''; ?>>Finalizado</option>
                            </select>
                        </div>

                        <div class="button">
                            <button type="submit" name="btn-gravar" class="btn btn-primary">Atualizar</button>
                            <button type="reset" name="btn-reset" class="btn btn-secondary">Limpar</button>
                            <a href="index.php" class="btn btn-danger">Voltar</a>
                        </div>
                    </form>
            <?php
                } else {
                    echo "<p>Agendamento não encontrado.</p>";
                    exit;
                }
            } else {
                echo "<p> Agendamento não especificado.</p>";
                exit;
            }
            ?>


        </div>
    </section>
    <footer>
        <p>&copy; Prefeitura de São Miguel do Iguaçu - Todos os direitos reservados.</p>
    </footer>
  <script>
    // Função para somar dias úteis a uma data
    function adicionarDiasUteis(data, diasParaAdicionar) {
      let result = new Date(data);
      while (result.getDay() === 0 || result.getDay() === 6) {
        result.setDate(result.getDate() + 1);
      }
      while (diasParaAdicionar > 0) {
        result.setDate(result.getDate() + 1);
        const diaSemana = result.getDay();
        if (diaSemana >= 1 && diaSemana <= 5) {
          diasParaAdicionar--;
        }
      }
      while (result.getDay() === 0 || result.getDay() === 6) {
        result.setDate(result.getDate() + 1);
      }
      return result;
    }

    // Função que retorna os próximos N dias úteis, começando 2 dias úteis após hoje
    function getProximosDiasUteis(qtd = 2) {
      const agora = new Date();
      const inicio = adicionarDiasUteis(agora, 2); // começa 2 diasuteis depois de hoje

      const diasUteis = [];
      let data = new Date(inicio);

      while (diasUteis.length < qtd) {
        const diaSemana = data.getDay();
        if (diaSemana >= 1 && diaSemana <= 5) {
          diasUteis.push(new Date(data));
        }
        data.setDate(data.getDate() + 1);
      }

      return diasUteis;
    }

    // Executa ao carregar a página
    window.addEventListener('DOMContentLoaded', function () {
      const dataInput = document.getElementById('data_agendamento');
      const horarioSelect = document.getElementById('horario');

      const horariosPorDia = {
        0: [], // Domingo
        1: ["07:40", "07:50", "08:00", "08:10", "08:20", "08:30", "08:40", "08:50", "09:00", "09:10", "09:20", "09:30", "09:40", "09:50", "10:00", "10:10", "10:20", "10:30", "10:40", "10:50", "11:00"],
        2: ["13:10", "13:20", "13:40", "13:50", "14:00", "14:10", "14:20", "14:30", "14:40", "14:50", "15:00", "15:10", "15:20", "15:30", "15:40", "15:50", "16:00", "16:10", "16:20", "16:30"],
        3: ["07:40", "07:50", "08:00", "08:10", "08:20", "08:30", "08:40", "08:50", "09:00", "09:10", "09:20", "09:30", "09:40", "09:50", "10:00", "10:10", "10:20", "10:30", "10:40", "10:50", "11:00"],
        4: ["13:10", "13:20", "13:40", "13:50", "14:00", "14:10", "14:20", "14:30", "14:40", "14:50", "15:00", "15:10", "15:20", "15:30", "15:40", "15:50", "16:00", "16:10", "16:20", "16:30"],
        5: ["13:10", "13:20", "13:40", "13:50", "14:00", "14:10", "14:20", "14:30", "14:40", "14:50", "15:00", "15:10", "15:20", "15:30", "15:40", "15:50", "16:00", "16:10", "16:20", "16:30"],
        6: [] // Sábado
      };

      // Calcula as datas válidas (dois dias úteis após 2 dias úteis de hoje)
      const diasUteis = getProximosDiasUteis(2);
      const minDate = diasUteis[0].toISOString().split('T')[0];
      const maxDate = diasUteis[1].toISOString().split('T')[0];

      dataInput.setAttribute('min', minDate);
      dataInput.setAttribute('max', maxDate);

      dataInput.addEventListener('input', function () {
        if (this.value < minDate || this.value > maxDate) {
          alert('Selecione uma data válida!');
          this.value = '';
         
          horarioSelect.innerHTML = '<option value="">Selecione uma data primeiro</option>';
        }
      });

      dataInput.addEventListener('change', function () {
        horarioSelect.innerHTML = '';
        if (!this.value) return;

        const dataSelecionada = new Date(this.value + 'T00:00:00'); // evita problemas de fuso
        const diaSemana = dataSelecionada.getDay();

        if (!horariosPorDia[diaSemana] || horariosPorDia[diaSemana].length === 0) {
          horarioSelect.innerHTML = '<option value="">Sem horários para este dia</option>';
          return;
        }

        horariosPorDia[diaSemana].forEach(hora => {
          const option = document.createElement('option');
          option.value = hora;
          option.textContent = hora;
          horarioSelect.appendChild(option);
        });
      });
    });
  </script>


</body>

</html>