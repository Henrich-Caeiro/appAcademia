<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="180x180" href="img/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/favicon_io/favicon-16x16.png">
  <title>MAX PHYSIQUES</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="css/style.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://unpkg.com/jquery-input-mask-phone-number@1.0.15/dist/jquery-input-mask-phone-number.js"></script>

</head>

<body>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#telefone').usPhoneFormat({
        format: '(xx) xxxxx-xxxx',
      });
    });
  </script>

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <form method = "GET">
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputFile">Foto do Instrutor</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
                <div class="input-group-append">
                  <span class="input-group-text">Upload</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="nome">Nome</label>
              <input type="text" name="nome" class="form-control" placeholder="Digite o nome" required>
            </div>
            <div class="form-group">
              <label for="data_nasc">Data de Nascimento</label>
              <input type="date" name="data_nasc" class="form-control" placeholder="Digite a data de nascimento" required>
            </div>
            <div class="form-group">
              <label for="cpf">CPF do Instrutor</label>
              <input type="text" name="cpf" class="form-control" placeholder="Digite o CPF" minlength=11 maxlength=11 required>
            </div>
            <div class="form-group">
              <label for="endereco">Endereço</label>
              <input type="text" name="endereco" class="form-control" placeholder="R. José Benetti, 508" required>
            </div>
            <div class="form-group">
              <label for="telefone">Telefone do Instrutor</label>
              <input id="telefone" type="text" required name="telefone" class="form-control" placeholder="(16)99768-0070" required>
            </div>
            <div class="form-group">
              <label for="login">Login do Instrutor</label>
              <input type="email" name="login" class="form-control" placeholder="nome@exemplo.com" required>
            </div>
            <div class="form-group">
              <label for="email">Senha do Instrutor</label>
              <input type="password" name="senha" class="form-control" placeholder="******" minlength=6 required>
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>

<?php
require_once "bancoDados.php";

if (
  isset($_GET["nome"]) and !empty($_GET["nome"]) and
  isset($_GET["data_nasc"]) and !empty($_GET["data_nasc"]) and
  isset($_GET["cpf"]) and !empty($_GET["cpf"]) and
  isset($_GET["endereco"]) and !empty($_GET["endereco"]) and
  isset($_GET["telefone"]) and !empty($_GET["telefone"]) and
  isset($_GET["login"]) and !empty($_GET["login"]) and
  isset($_GET["senha"]) and !empty($_GET["senha"])
) {

  $nome = $_GET["nome"];
  $data_nasc = $_GET["data_nasc"];
  $cpf = $_GET["cpf"];
  $endereco = $_GET["endereco"];
  $telefone = $_GET["telefone"];
  $login = $_GET["login"];
  $senha = $_GET["senha"];

  $hash = password_hash($senha, PASSWORD_BCRYPT, ["cost" => 11]);

  //verifica tamanho do CPF
  if (strlen($cpf) == 11) {
    //veriffica tamanho telefone
    if (strlen($telefone) >= 11) {
      //verifica tamanho da senha
      if (strlen($senha) >= 6) {

        try {
          $conexao = Conexao::getConexao();

          $stmt = $conexao->prepare("INSERT INTO instrutor(nome, dataNasc, cpf, endereco, telefone, login, hash) VALUES(?,?,?,?,?,?,?)");
          $stmt->execute([$nome, $data_nasc, $cpf, $endereco, $telefone, $login, $hash]);

        } catch (Exception $e) {
          echo '<script type="text/javascript">
                  alert('.$e.');
                </script>';
        }
      }
    }
  }
}
?>