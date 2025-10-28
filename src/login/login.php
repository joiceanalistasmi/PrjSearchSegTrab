
 <?php
include("../../conexao.php");
session_start();
date_default_timezone_set('America/Sao_Paulo');
 
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (!empty($username) && !empty($password) ) {
        
        if ($role === 'admin') {
            $sql = mysqli_query($conexao, "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password' AND role = 'admin'");
            //direcionar para a pagina de admin que refere-se ao medico-a.
           // location.href = 'protocolo.php';

        } else {
            $sql = mysqli_query($conexao, "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password' AND role = 'user'");
    }

       

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Agendamentos</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../../responsive.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>

form.cadastro {
    background-color: #ffffff;
    max-width: 400px;
    margin: 80px auto;
    padding: 30px 25px;
    border-radius: 8px;
    box-shadow: 0 2px 12px rgba(44, 55, 156, 0.15);
    text-align: left;
}

form.cadastro label {
    color: #062d52ff;
    font-weight: bold;
    margin-bottom: 5px;
}

form.cadastro input[type="text"],
form.cadastro input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
    margin-bottom: 15px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

form.cadastro input:focus {
    border-color: #0676aa;
    box-shadow: 0 0 4px rgba(6, 118, 170, 0.3);
    outline: none;
}

/* Checkboxes */
.form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 10px 0 20px 0;
}

.form-check label {
    margin: 0;
    color: #333;
    font-weight: normal;
}

/* Botão */
form.cadastro button.btn-primary {
    width: 100%;
    background-color: #0676aa;
    border: none;
    color: #fff;
    padding: 10px;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

form.cadastro button.btn-primary:hover {
    background-color: #005c85;
}

/* Centralização e espaçamento do section */
section {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 180px);
    background-color: #f8f9fb;
}

/* Responsivo */
@media (max-width: 600px) {
    form.cadastro {
        width: 90%;
        padding: 20px;
    }
}
    </style>
</head>
<body>
<header>
    <img src="../../imagens/logo1.jpg" alt="Logo" class="logo">
    <div>
        <img src="../../imagens/prefeitura.jpg" alt="Prefeitura de São Miguel do Iguaçu">
    </div>
</header>

<section>
<form class="cadastro" action="" method="POST" name="formLogin" id="formLogin">
  <div class="form-group">
    <label for="exampleInputEmail1">Usuário</label>
    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Seu usuário">
    <small id="username" class="form-text text-muted"></small>
  </div>
  <div class="form-group">
    <label for="password">Senha</label>
    <input type="password" class="form-control" id="password" placeholder="Senha">
  </div>
  <div class="form-group form-check">
    <input type="radio" class="form-check-input" id="role" value="admin" checked>
    <label class="form-check-label" for="roleAdm" >Administrador</label>
    <input type="radio" class="form-check-input" id="role" value="user">
    <label class="form-check-label" for="roleUser">Usuário</label>
  </div>
  <button type="submit" class="btn btn-primary">Enviar</button>
</form>
</section>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Prefeitura de São Miguel do Iguaçu - Todos os direitos reservados.</p>    
</footer>
</body>
</html>