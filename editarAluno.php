<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once "bancoDados.php";
    require_once "sessao.php";

    if(sizeof($_SESSION) == 0){
        header('Location: login.php');
    }else if (isset($_POST["editar"]) and !empty($_POST["editar"])){
        $cpf = $_POST["editar"];
    }else if (isset($_GET["cpf"]) and !empty($_GET["cpf"])){
        $cpf = $_GET["cpf"];
    }

    $conexao = Conexao::getConexao();

    $stmt = $conexao->prepare("SELECT * FROM aluno WHERE cpf = (?)");
    $stmt->execute([$cpf]);
    $aluno = $stmt->fetchALL();

    if(sizeof($aluno) != 0){
        $nome = $aluno[0]["nome"];
        $dataNasc = $aluno[0]["dataNasc"];
        $cpf = $aluno[0]["cpf"];
        $login = $aluno[0]["login"];
    }else{
        echo "<script> alert('Dados não encontrados!') </script>";
    }

    require_once "template-parts/header.php";
?>

<form method = "GET" id="formEdita">
  <div class="card-body">
    <div class="form-group">
      <label for="nome">Nome</label>
      <input type="text" name="nome" class="form-control" placeholder="Digite o nome" value="<?=$nome?>" required>
    </div>
    <div class="form-group">
      <label for="data_nasc">Data de Nascimmento</label>
      <input type="date" name="data_nasc" class="form-control" placeholder="Digite a data de nascimento" value="<?=$dataNasc?>" required>
    </div>
    <div class="form-group">
      <label for="cpf">CPF do Aluno</label>
      <input type="text" name="cpf" class="form-control" placeholder="Digite o CPF" minlength=11 maxlength=11 value="<?=$cpf?>" readonly>
    </div>
    <div class="form-group">
      <label for="login">Login do aluno</label>
      <input type="email" name="login" class="form-control" placeholder="nome@exemplo.com" value="<?=$login?>" required>
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
</form>

<form action="listarAvaliacao.php" id="formListaAvaliacao" method="GET">
    <input type="hidden" name="cpf" value="<?=$cpf?>">
</form>

<div class="card-footer">
    <button form="formEdita" type="submit" class="btn btn-warning">Salvar mudanças</button>
    <button form="formListaAvaliacao" type="submit" class="btn btn-info">Listar avaliações</button>
</div>


<?php 
    require_once "template-parts/footer.php";
    
    if (
        isset($_GET["nome"]) and !empty($_GET["nome"]) and
        isset($_GET["data_nasc"]) and !empty($_GET["data_nasc"]) and
        isset($_GET["login"]) and !empty($_GET["login"])) {
      
        $nome = $_GET["nome"];
        $data_nasc = $_GET["data_nasc"];
        $login = $_GET["login"];

      try {
        $conexao = Conexao::getConexao();
        $stmt = $conexao->prepare("SELECT idInstrutor FROM aluno WHERE cpf = (?)");
        $stmt->execute([$cpf]);
        $idInstrutor = $stmt->fetchALL();

        $idInstrutor = $idInstrutor[0]["idInstrutor"];

        if($idInstrutor == $_SESSION["id"]){
            
            $conexao = Conexao::getConexao();
      
            $stmt = $conexao->prepare("UPDATE aluno SET nome = (?), dataNasc = (?), login = (?) WHERE cpf = (?)");
            $stmt->execute([$nome, $data_nasc, $login, $cpf]);
        }else{
            echo "<script> alert('Hey! Esse aluno não é seu!') </script>";
        }

      } catch (\Throwable $th) {
            echo '<script type="text/javascript">
                alert('.$th.');
            </script>';
      }
        


        
    }
      
?>