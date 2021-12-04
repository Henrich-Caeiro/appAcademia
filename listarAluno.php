<?php require_once 'template-parts/header.php' ?>


<div class="card">
  <div class="card-header">
    <h3 class="card-title">Lista de Alunos cadastrados no sistema</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
      <div class="row">
        <div class="col-sm-12 col-md-6"></div>
        <div class="col-sm-12 col-md-6"></div>
      </div>

      <!-- Tabela de alunos -->
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
            <thead>
              <tr>
                <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Nome</th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Data de nascimento</th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">E-mail</th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Opções</th>
              </tr>
            </thead>
            <tbody>
                <!-- função para listar cada um dos alunos -->
                <?php listar_alunos() ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</div>

<?php require_once "template-parts/footer.php";

  function listar_alunos(){
    require_once "bancoDados.php";

    try {
          $conexao = Conexao::getConexao();

          $stmt = $conexao->prepare("SELECT nome,dataNasc,login,cpf FROM aluno");
          $stmt->execute();
          $vetor_alunos = $stmt->fetchALL();

          foreach ($vetor_alunos as $aluno) {
              $cpf=$aluno["cpf"];

              echo "<tr class='odd'>";
              echo "<td class='dtr-control sorting_1' tabindex='0'>" . $aluno["nome"] . "</td>";
              echo "<td>" . $aluno["dataNasc"] . "</td>";
              echo "<td>" . $aluno["login"] . "</td>";
              ?>
              <td class="text-center justify-between">
                  <button form="formAvaliacao" class="btn btn-success"> Avaliação </button>
                  <button form="formEdit" class="btn btn-info"> Editar </button>
                  <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModal"> Deletar </button>
              </td>
              </tr>
              <!-- AVALIAÇÃO -->
              <form id="formAvaliacao" method="POST" action="avaliacao.php">
                <input name="avaliar" type="hidden" value="<?=$cpf?>">
              </form>
              <!-- EDIÇÃO -->
              <form id="formEdit" method="POST" action="editarAluno.php">
                <input name="editar" type="hidden" value="<?=$cpf?>">
              </form>
              <!-- DELEÇÃO -->
              <form id="formDelete" method="POST" action="template-parts/aluno/deletar.php">
                <input name="deletar" type="hidden" value="<?=$cpf?>">
              </form>
              <!--lógica do modal-->
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Atenção!</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Isso apagará permanentemente o aluno! Você tem certeza que quer continuar?</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button form="formDelete" type="submit" class="btn btn-danger">Confirmar</button>
                    </div>
                  </div>
                </div>
              </div>
            <?php
          }//fim foreach
        }//fim try

      catch (\Throwable $th) {
        echo '<script type="text/javascript">
                  alert(' . $th . ');
              </script>';
      }
  }//fecha função 
  
?>
