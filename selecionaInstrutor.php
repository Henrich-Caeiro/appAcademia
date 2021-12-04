<?php
//faz um select com o nome dos instrutores cadastrados
function exibir_instrutores(){
  require_once "bancoDados.php";
  
  try {
    
    $conexao = Conexao::getConexao();

    $stmt = $conexao->prepare("SELECT nome FROM instrutor ORDER BY nome");
    $stmt->execute();

    $instrutores = $stmt->fetchAll();
    
    foreach ($instrutores as $key => $instrutor) {
      $nome = $instrutor["nome"];
      echo "<option value='$nome'>$nome</option>";
    }

  } catch (\Throwable $th) {
    echo '<script type="text/javascript">
            alert('.$th.');
          </script>';
  }
}