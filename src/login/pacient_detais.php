
<?php

 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
 <header>
    <img src="../../imagens/logo1.jpg" alt="Logo" class="logo">
    <div>
        <img src="../../imagens/prefeitura.jpg" alt="Prefeitura de São Miguel do Iguaçu">
    </div>
</header>
<section>
<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="cid">CID</label>
      <input type="text" class="form-control" id="cid" placeholder="cid">
    </div>
    <div class="form-group col-md-6">
      <label for="data_inicio">Data de Inicio: </label>
      <input type="date" class="form-control" id="data_inicio" >
    </div>
    <div class="form-group col-md-6">
      <label for="data_fim">Data de Fim: </label>
      <input type="date" class="form-control" id="data_fim" >
    </div>
  </div>
  <div class="form-group col-md-6">
        <label for="tipo_atendimento">Tipo de Atendimento*</label>
        <select id="tipo_atendimento" name="tipo" required>
          <option value="consulta">Retorno ao Trabalho</option>
          <option value="Homologacao_de_Atestado">Homologação de Atestado</option>
        </select>
      </div>

  <div class="form-group">
    <label for="observacao">Observação: </label>
    <input type="text" class="form-control" id="observacao" placeholder="observacao">
  </div>
 
   <button type="submit" class="btn btn-primary">Enviar</button>

</form>
</section> 
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


<footer>
    <p>&copy; <?php echo date("Y"); ?> Prefeitura de São Miguel do Iguaçu - Todos os direitos reservados.</p>
</footer>

<body>


 </html>

