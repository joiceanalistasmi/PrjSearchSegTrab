<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agendamento para perícia médica</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <link rel="stylesheet" href="responsive.css" />
</head>

<body>
  <header>
    <img src="imagens/logo1.jpg" alt="Logo" class="logo">
    <div>
      <img src="imagens/prefeitura.jpg" alt="Prefeitura de São Miguel do Iguaçu">
    </div>
  </header>

  <section>
    <form class="cadastro" action="processar_agendamento.php" method="POST" name="formAgenda" id="formAgenda">
      <h4>Formulário de Agendamento - Perícia médica - Segurança do trabalho</h4>

      <div>
        <label for="nome_servidor">Nome do Servidor*</label>
        <input type="text" id="nome_servidor" name="nome_servidor" maxlength="100" required />
      </div>

      <div>
        <label for="tipo_usuario">Tipo de Usuário*</label>
        <select id="tipo_usuario" name="tipo_de_usuario" required>
          <option value="servidorPublico">Servidor público</option>
          <option value="acompanhante">Acompanhante</option>
        </select>
      </div>

      <div>
        <label for="nome_acompanhante">Nome do Acompanhante (quando necessário)</label>
        <input type="text" id="nome_acompanhante" name="nome_acompanhante" maxlength="100" />
      </div>

      <div>
        <label for="telefone">Telefone*</label>
        <input type="tel" id="telefone" name="telefone" maxlength="100" placeholder="(xx)xxxxx-xxxx" required />
      </div>

      <div>
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" maxlength="100" />
      </div>

      <div>
        <label for="tipo_atendimento">Tipo de Atendimento*</label>
        <select id="tipo_atendimento" name="tipo" required>
          <option value="consulta">Retorno ao Trabalho</option>
          <option value="Homologacao_de_Atestado">Homologação de Atestado</option>
        </select>
      </div>

      <div>
        <label for="data_agendamento">Data do Agendamento*</label>
        <input type="date" id="data_agendamento" name="data_agendamento" required />
      </div>

      <div>
        <label for="horario">Horário</label>
        <select id="horario" name="horario" required>
          <option value="">Selecione uma data primeiro</option>
        </select>
      </div>

      <div>
        <label for="status">Status</label>
        <select id="status" name="status" required>
          <option value="confirmado" selected>Agendar</option>
          <option value="cancelado">Remarcar</option>
        </select>
      </div>

      <div class="button">
        <button type="submit">AGENDAR</button>
        <button type="reset">LIMPAR</button>
      </div>
    </form>
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
      const inicio = adicionarDiasUteis(agora, 1); // começa 2 diasuteis depois de hoje  / coloquei 1  mas tem que verificar 

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
