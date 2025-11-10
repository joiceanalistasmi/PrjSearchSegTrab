<?php
$servidor_id_get = isset($_GET['servidor_id']) ? $_GET['servidor_id'] : '';
$servidor_nome_get = isset($_GET['servidor_nome']) ? $_GET['servidor_nome'] : '';
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Servidor</title>

    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function save() {
  const form = document.getElementById('formServidor');
  const formData = new FormData(form);

  fetch('processa_pacientDetails.php', {
    method: 'POST',
    body: formData
  })
  .then(r => r.text())
  .then(result => {
    document.body.innerHTML = result; // mostra o retorno do PHP
  });
}
        </script>
</head>

<body>
<header>
    <img src="../../imagens/logo1.jpg" alt="Logo" class="logo">
    <div>
        <img src="../../imagens/prefeitura.jpg" alt="Prefeitura de São Miguel do Iguaçu">
    </div>
</header>

<section class="p-4">

<form id="formServidor" method="POST" action="processa_pacientDetails.php"  >

  <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Pesquisar nome de servidor" id="nome_servidor" name="nome_servidor">
      <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" id="btnConsultar">Consultar</button>
      </div>
  </div>
  <div class="form-group col-md-6">
  <label for="servidor">Servidor Selecionado:</label>
  <input type="text" class="form-control" id="servidor" name="servidor" 
         value="<?php echo htmlspecialchars($servidor_nome_get); ?>">
  <input type="hidden" id="servidor_id" name="servidor_id" 
         value="<?php echo htmlspecialchars($servidor_id_get); ?>">
</div>
  
<!--  cadastra os procedimentos de paciente -->
  <div class="form-row">
      <div class="form-group col-md-6">
          <label for="cid">CID</label>
          <input type="text" class="form-control" id="cid" placeholder="CID" name="cid" >
        <?php

        ?>
      </div>
      <div class="form-group col-md-6">
          <label for="data_inicio">Data de Início</label>
          <input type="date" class="form-control" id="data_inicio" name="data_inicio">
      </div>
      <div class="form-group col-md-6">
          <label for="data_final">Data de Fim</label>
          <input type="date" class="form-control" id="data_final" name="data_final">
      </div>
  </div>

  <div class="form-group col-md-6">
      <label for="tipo_servico">Tipo de Atendimento*</label>
      <select  class="form-control"  name="tipo_servico" id="tipo_servico">
          <option value="consulta">Retorno ao Trabalho</option>
          <option value="Homologacao_de_Atestado">Homologação de Atestado</option>
      </select>
  </div>

  <div class="form-group">
      <label for="observacao">Observação:</label>
      <textarea  class="form-control" id="observacao" placeholder="Observação" name="observacao" rows="3"></textarea>
  </div>

  <button type="button" class="btn btn-primary" onclick="save()">Cadastrar Procedimento</button>
  <button type="reset" class="btn btn-secondary">Limpar</button>
</form>
</section>
<section>
    <div id="listaProcedimentos" class="mt-4"></div>
</section>

<!-- Modal -->
<div class="modal fade" id="detalheModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Servidores Encontrados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalDetalhes">
        <!-- resultadooo  -->
      </div>
    </div>
  </div>
</div>

<footer class="text-center mt-4">
    <p>&copy; <?php echo date("Y"); ?> Prefeitura de São Miguel do Iguaçu - Todos os direitos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $("#btnConsultar").click(function() {
        const nome = $("#nome_servidor").val().trim();

       /* if (nome.length < 2) {
            alert("Digite ao menos 2 letras para pesquisar.");
            return;
        }*/

        $.ajax({
            url: "list_servidorPacient.php",
            type: "POST",
            data: { nome_servidor: nome },
            success: function(data) {
                console.log("Resposta do servidor:", data);
                $("#modalDetalhes").html(data);
                $("#detalheModal").modal("show");
            },
            error: function() {
                alert("Erro ao buscar servidor.");
            }
        });
    });

    // lista
   $(document).on("click", ".servidor-item", function() {
    const nomeSelecionado = $(this).text().trim();
    const servidor_id = $(this).data("id");
    
     console.log("Nome selecionado:", nomeSelecionado);  
     console.log("ID capturado:", servidor_id);

    $("#servidor").val(nomeSelecionado);
    $("#servidor_id").val(servidor_id);
    $("#detalheModal").modal("hide");

     $.ajax({
            url: "list_pacientDetails.php",
            type: "POST",
            data: { servidor_id: servidor_id },
            beforeSend: function() {
                $("#listaProcedimentos").html("<p>Carregando procedimentos...</p>");
            },
            success: function(data) {
                $("#listaProcedimentos").html(data);
            },
            error: function(xhr) {
                console.error("Erro Ajax:", xhr.responseText);
                $("#listaProcedimentos").html("<p>Erro ao carregar os procedimentos.</p>");
            }
    });
});

$(document).ready(function() {
    const servidor_id = $("#servidor_id").val();

    if (servidor_id) {
        // Se o servidor já estiver selecionado (via GET), carrega seus procedimentos automaticamente
        $.ajax({
            url: "list_pacientDetails.php",
            type: "POST",
            data: { servidor_id: servidor_id },
            beforeSend: function() {
                $("#listaProcedimentos").html("<p>Carregando procedimentos...</p>");
            },
            success: function(data) {
                $("#listaProcedimentos").html(data);
            },
            error: function() {
                $("#listaProcedimentos").html("<p>Erro ao carregar os procedimentos.</p>");
            }
        });
    }
});
});
function save() {
  const form = document.getElementById('formServidor');
  const formData = new FormData(form);

  formData.append('action', 'save');

  fetch('processa_pacientDetails.php', {
    method: 'POST',
    body: formData
  })
  .then(r => r.json()) // muda de .text() para .json()
  .then(result => {
    if (result.status === "ok") {
      alert(result.mensagem);
      window.location.href = result.redirect; // redireciona corretamente
    } else {
      alert(result.mensagem);
    }
  })
  .catch(err => console.error("Erro no fetch:", err));
}


</script>

</body>
</html>
