<?php 
      require_once "sessao.php";
      require_once "template-parts/header.php";
 ?>


<form method = "GET">
  <div class="card-body">
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" name="nome" class="form-control" placeholder="Digite o nome" required>
    </div>
    <div class="form-group">
      <label for="data_nasc">Data de Nascimmento</label>
      <input type="date" name="data_nasc" class="form-control" placeholder="Digite a data de nascimento" required>
    </div>
    <div class="form-group">
      <label for="cpf">CPF do Aluno</label>
      <input type="text" name="cpf" class="form-control" placeholder="Digite o CPF" minlength=11 maxlength=11 required>
    </div>
    <div class="form-group">
      <label for="login">Login do aluno</label>
      <input type="email" name="login" class="form-control" placeholder="nome@exemplo.com" required>
    </div>
    <div class="form-group">
      <label for="email">Senha do Aluno</label>
      <input type="password" name="senha" class="form-control" placeholder="******" minlength=6 required>
    </div>
    <div class="form-group">
      <label for="exampleInputFile">Foto do Aluno</label>
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
  </div>

  <div class="card-footer">
    <button type="submit" class="btn btn-primary">Cadastrar</button>
  </div>
</form>

<?php
require_once "bancoDados.php";
require_once "template-parts/footer.php";

//checagem de parâmetros
if (
  isset($_GET["nome"]) and !empty($_GET["nome"]) and
  isset($_GET["data_nasc"]) and !empty($_GET["data_nasc"]) and
  isset($_GET["cpf"]) and !empty($_GET["cpf"]) and
  isset($_GET["login"]) and !empty($_GET["login"]) and
  isset($_GET["senha"]) and !empty($_GET["senha"])
) {

  $nome = $_GET["nome"];
  $data_nasc = $_GET["data_nasc"];
  $cpf = $_GET["cpf"];
  $login = $_GET["login"];
  $senha = $_GET["senha"];

  $hash = password_hash($senha, PASSWORD_BCRYPT, ["cost" => 11]);

  //verifica tamanho do CPF
  if (strlen($cpf) == 11) {
    //verifica tamanho da senha do aluno
    if (strlen($senha) == 6) {
    
      try {
        $conexao = Conexao::getConexao();

        //seleciona o id do instrutor selecionado
        $id_instrutor = $_SESSION["id"];

        $stmt = $conexao->prepare("INSERT INTO aluno(idInstrutor, nome, dataNasc, cpf, login, hash) VALUES(?,?,?,?,?,?)");
        $stmt->execute([$id_instrutor, $nome, $data_nasc, $cpf, $login, $hash]);

      } catch (\Throwable $th) {
        echo '<script type="text/javascript">
                  alert('.$th.');
                </script>';
      }
    }
  }
}
?>