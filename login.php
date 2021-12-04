<?php 
    require_once "sessao.php";
  
    //verifica se o usuário está logado
    if(isset($_SESSION["login"])){
        header("Location: home.php");
        die;
    }
    require_once "template-parts/header-login.php";
?>
<main>
  <h1 class="text-center welcome mt-5">Bem Vindo</h1>

  <div class="row justify-content-center mt-5">
    <div class="col-xs-12 col-md-6 text-center">
      <form class="form-login form-group" action="" method="POST">
        <div class="col-md-12">
          <h2 class="text-center">Login</h2>
        </div>
        <input class="text-center form-control" type="email" name="login" placeholder="nome@exemplo.com"><br>
        <input class="text-center form-control" type="password" name="senha" placeholder="******" minlength=6><br>
        <div class="row justify-content-between">
          <div class="col-md-6 float-left text-left">
            <label for="user_type"><input name="usuario" value="aluno" type="radio" aria-label="Teste"> Aluno</label>
          </div>
          <div class="col-md-6 float-left">
            <label for="user_type"><input name="usuario" value="instrutor" type="radio" aria-label="Teste"> Professor</label>
          </div>

        </div>
        <input type="submit" name="" class="btn btn-primary" value="Entrar"><br>
      </form>
    </div>

  </div>
</main>

<?php require_once 'template-parts/footer-login.php';

require_once "bancoDados.php";

if (
  isset($_POST["login"]) and !empty($_POST["login"]) and
  isset($_POST["senha"]) and !empty($_POST["senha"]) and
  isset($_POST["usuario"]) and !empty($_POST["usuario"])
) {
  
  $login = $_POST["login"];
  $senha = $_POST["senha"];
  $usuario = $_POST["usuario"];

  //verifica tamanho da senha
  if (strlen($senha) >= 6) {
    
    try {
      $conexao = Conexao::getConexao();

      //ALUNO
      if($usuario == "aluno"){
        $stmt = $conexao->prepare("SELECT hash FROM aluno WHERE login = (?)");
        $stmt->execute([$login]);
        $hash = $stmt->fetchALL();

        $hash = $hash[0]["hash"];
        
        //verifica se o usuario existe
        if(!empty($hash)){
          //verifica senha
          if(password_verify($senha,$hash)){

            $_SESSION["login"] = $login; 
            $_SESSION["usuario"] = $usuario;
            
            header("Location: home.php");
            die;

          }else{
            echo '<script type="text/javascript">
                  alert("Erro: Senha incorreta!");
            </script>';
          }
        }else{
          echo '<script type="text/javascript">
                  alert("Erro: Usuário não existe!");
            </script>';
        }


      //INSTRUTOR
      }elseif($usuario == "instrutor"){
        $stmt = $conexao->prepare("SELECT hash FROM instrutor WHERE login = (?)");
        $stmt->execute([$login]);
        $hash = $stmt->fetchALL();

        $hash = $hash[0]["hash"];
        
        //verifica se o usuario existe
        if(!empty($hash)){
          //verifica senha
          if(password_verify($senha,$hash)){

            $stmt = $conexao->prepare("SELECT id FROM instrutor WHERE login = (?)");
            $stmt->execute([$login]);
            $id_instrutor = $stmt->fetchALL();

            $id_instrutor = $id_instrutor[0]["id"];

            $_SESSION["login"] = $login; 
            $_SESSION["usuario"] = $usuario; 
            $_SESSION["id"] = $id_instrutor; 

            header("Location: home.php");
            die;

          }else{
            echo '<script type="text/javascript">
                  alert("Erro: Senha incorreta!");
            </script>';
          }
        }else{
          echo '<script type="text/javascript">
                  alert("Erro: Usuário não existe!");
            </script>';
        }
      }

    } catch (\Throwable $th) {
      echo '<script type="text/javascript">
                  alert(' . $th . ');
            </script>';
    }
  }
}

?>