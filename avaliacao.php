<?php 

      require_once "sessao.php";

      if(sizeof($_SESSION) == 0){
        header('Location: login.php');
      }else if (isset($_POST["avaliar"]) and !empty($_POST["avaliar"])){
        $cpf = $_POST["avaliar"];
      }else if (isset($_POST["cpf"]) and !empty($_POST["cpf"])){
        $cpf = $_POST["cpf"];
      }
      
      require_once 'template-parts/header.php';
?>

<form method = "POST">
  <div class="card-body">
  
  <!-- recupera o cpf passado -->
  <input name="cpf" type="hidden" value="<?=$cpf?>">
    
    <div class="form-group">
      <label for="massa">Massa KG</label>
      <input type="text" name="massa" class="form-control" placeholder="KG" required>
    </div>
    <div class="form-group">
      <label for="gordura">% Gordura</label>
      <input step="any" type="number" name="gordura" class="form-control" placeholder="Percentural de gordura %" required>
    </div>
    <div class="form-group">
      <label for="altura">Altura</label>
      <input type="number" name="altura" class="form-control" placeholder="Altura em Metros" required>
    </div>
    <div class="form-group">
      <label for="torax">Torax</label>
      <input type="number" name="torax" class="form-control" placeholder="Medida do torax em CM" required>
    </div>
    <div class="form-group">
      <label for="abdomen">Abdomen</label>
      <input type="number" name="abdomen" class="form-control" placeholder="Medida do abdomen em CM"  required>
    </div>
    <div class="form-group">
      <label for="quadril">Quadril</label>
      <input type="number" name="quadril" class="form-control" placeholder="Medida do quadril em CM"required>
    </div>
    <div class="form-group">
      <label for="exampleInputFile">Foto</label>
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

//verifica dados do formulário
if(isset($_POST["cpf"]) and !empty($_POST["cpf"]) and
  isset($_POST["massa"]) and !empty($_POST["massa"]) and
  isset($_POST["gordura"]) and !empty($_POST["gordura"]) and
  isset($_POST["altura"]) and !empty($_POST["altura"]) and
  isset($_POST["torax"]) and !empty($_POST["torax"]) and
  isset($_POST["abdomen"]) and !empty($_POST["abdomen"]) and
  isset($_POST["quadril"]) and !empty($_POST["quadril"]) ){

    $idInstrutor = $_SESSION["id"];
    $cpf = $_POST["cpf"];
    $data = date('Y/m/d');
    $massa = $_POST["massa"];
    $gordura = $_POST["gordura"];
    $altura = $_POST["altura"];
    $torax = $_POST["torax"];
    $abdomen = $_POST["abdomen"];
    $quadril = $_POST["quadril"];

    $conexao = Conexao::getConexao();

    $stmt = $conexao->prepare("INSERT INTO avaliacao(cpfAluno, idInstrutor, data, massa, gordura, altura, torax, abdomen, quadril) VALUES(?,?,?,?,?,?,?,?,?)");
    $stmt->execute([$cpf, $idInstrutor, $data, $massa, $gordura, $altura, $torax, $abdomen, $quadril]);
}

?>