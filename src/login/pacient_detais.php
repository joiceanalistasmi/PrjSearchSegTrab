<?php include("../../conexao.php"); ?>
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
</head>

<body>
<header>
    <img src="../../imagens/logo1.jpg" alt="Logo" class="logo">
    <div>
        <img src="../../imagens/prefeitura.jpg" alt="Prefeitura de São Miguel do Iguaçu">
    </div>
</header>

<section class="p-4">
<form id="formServidor" method="POST">

  <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Pesquisar nome de servidor..." id="nome_servidor" name="nome_servidor">
      <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="button" id="btnConsultar">Consultar</button>
      </div>
  </div>
  <div class="form-group col-md-6">
      <label for="servidor">Servidor Selecionado:</label>
      <input type="text" class="form-control" id="servidor" placeholder="Selecione o servidor">
  </div>
<!-- aqui começa o form para add-->
  <div class="form-row">
      <div class="form-group col-md-6">
          <label for="cid">CID</label>
          <input type="text" class="form-control" id="cid" placeholder="CID">
        <?php

        ?>
      </div>
      <div class="form-group col-md-6">
          <label for="data_inicio">Data de Início</label>
          <input type="date" class="form-control" id="data_inicio">
      </div>
      <div class="form-group col-md-6">
          <label for="data_fim">Data de Fim</label>
          <input type="date" class="form-control" id="data_fim">
      </div>
  </div>

  <div class="form-group col-md-6">
      <label for="tipo_atendimento">Tipo de Atendimento*</label>
      <select class=" c-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
          <option value="consulta">Retorno ao Trabalho</option>
          <option value="Homologacao_de_Atestado">Homologação de Atestado</option>
      </select>
  </div>

  <div class="form-group">
      <label for="observacao">Observação:</label>
      <input type="text" class="form-control" id="observacao" placeholder="Observação">
  </div>

  <button type="submit" class="btn btn-primary">Cadastrar</button>
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
        <!-- Resultados aparecem aqui -->
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

    // Ao clicar no botão Consultar
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
                $("#modalDetalhes").html(data);
                $("#detalheModal").modal("show");
            },
            error: function() {
                alert("Erro ao buscar servidor.");
            }
        });
    });

    // Quando clicar em um servidor na lista
    $(document).on("click", ".servidor-item", function() {
        const nomeSelecionado = $(this).text();
        $("#servidor").val(nomeSelecionado);
        $("#detalheModal").modal("hide");

        // Buscar lista de procedimentos do servidor
        $.ajax({
            url: "list_pacientDetails.php",
            type: "POST",
            data: { servidor: nomeSelecionado },
            success: function(data) {
                $("#listaProcedimentos").html(data);
            },
            error: function() {
                $("#listaProcedimentos").html("<p>Erro ao carregar os procedimentos.</p>");
            }
    });
    });

});



</script>

</body>
</html>
