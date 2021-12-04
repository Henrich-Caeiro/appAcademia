<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once "sessao.php";
    require_once "bancoDados.php";

    if(sizeof($_SESSION) == 0){
        header('Location: login.php');
    }else if (isset($_POST["cpf"]) and !empty($_POST["cpf"])){
        $cpf = $_POST["cpf"];
    }else if (isset($_GET["cpf"]) and !empty($_GET["cpf"])){
        $cpf = $_GET["cpf"];
    }

    try {
        $conexao = Conexao::getConexao();

        $stmt = $conexao->prepare("SELECT nome FROM aluno WHERE cpf = (?)");
        $stmt->execute([$cpf]);
        $info = $stmt->fetchALL();
        $nome = $info[0]["nome"];

        $stmt = $conexao->prepare("SELECT * FROM avaliacao WHERE cpfAluno = (?) ORDER BY DATA DESC");
        $stmt->execute([$cpf]);
        $vetorAvaliacoes = $stmt->fetchALL();

        var_dump($vetorAvaliacoes);

        if(sizeof($vetorAvaliacoes)){

            foreach ($vetorAvaliacoes as $aluno) {

                $massa = $aluno["massa"];
                $gordura = $aluno["gordura"];
                $altura = $aluno["altura"];
                $torax = $aluno["torax"];
                $abdomen = $aluno["abdomen"];
                $quadril = $aluno["quadril"];
                $data = $aluno["data"];
    
            }

        }
        
    } catch (\Throwable $th) {
        echo '<script type="text/javascript">
                alert('.$th.');
            </script>';
    }
    


?>