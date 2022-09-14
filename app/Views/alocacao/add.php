<?php
echo $this->extend('layouts2/default'); ?>
<?= $this->section('content');

$alocacaoSerie = [];
$alocacaoPosicao = [];
$alocacaoDiaSemana = [];

foreach ($alocacao as $data) :
  //$alocacaoSerie[] = $data->id_serie'];
  $alocacaoPosicao[] = $data->position;
  $alocacaoDiaSemana[] = $data->dayWeek;
endforeach;

?>
<div class="content-header">
  <div class="container">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <?php
          foreach ($breadcrumb as $item) {
            echo $item;
          } ?>

        </ol>
      </div>
    </div>
  </div>
</div>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="<?= $alocacao !== [] ? 'col-md-6' : 'col-md-12'; ?>">
        <?php if ($msgs['alert']) : ?>
          <div class="alert alert-close alert-<?= $msgs['alert'] ?> bg-<?= $msgs['alert'] ?> text-light border-0 alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-triangle"></i><?= $msgs['message']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
        <?php endif; ?>
        <div class="card card-dark">

          <div class="card-header">
            <h3 class="card-title font-weight-bold"><?= $title ?></h3>
          </div>

          <?php echo form_open('alocacao/create', ['class' => '']);
          echo csrf_field();
          ?>
          <div class="card-body">
            <div class="form-group <?= $alocacao !== [] ? 'col-12' : 'col-6'; ?>">
              <label for="inputEmail3" class="col-form-label">Professor(a) :: </label>
              <input type="text" disabled="true" name="" class="form-control" value="<?= $professor->name; ?>">
              <input type="hidden" name="nIdProfessor" value="<?= $professor->id; ?>">
            </div>
            <div class="row">
              <div class="form-group col-6 mb-0">
              </div>
            </div>
            <div class="row <?= $alocacao !== [] ? 'col-md-12' : 'col-6'; ?>">
              <div class="form-group col-6">

                <label for="inputEmail3" class="col-form-label" id="">Dia Semana :: <span id="checkAll"><i class="fa fa-check-double" title="Marcar todos"></i></span> </label>
                <?php for ($i = 2; $i <= 6; $i++) : ?>

                  <div class="form-check custom-switch">
                    <input class="form-check-input marcar" name="nDayWeek[]" value="<?= $i; ?>" <?= set_checkbox('nDayWeek', $i); ?> type="checkbox" role="switch" id="dayWeek<?= $i; ?>">
                    <label class="form-check-label" for="dayWeek<?= $i; ?>"><?= diaSemanaExtenso($i); ?></label>

                  </div>


                <?php endfor; ?>
                <?php if ($erro !== '')
                  echo generateAlertFieldErro($erro->getError('nDayWeek')); ?>



              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-form-label">Posição Aula :: </label>

                <?php
                for ($i = 1; $i <= 6; $i++) : ?>

                  <div class="form-check form-switch">
                    <input class="form-check-input" name="nPosition[]" value="<?= $i; ?>" <?= set_checkbox('nPosition', $i); ?> type="checkbox" role="switch" id="checboxPosicao<?= $i; ?>">
                    <label class="form-check-label" for="checboxPosicao<?= $i; ?>"><?= $i . 'ª AULA'; ?></label>
                  </div>
                <?php
                endfor; ?>
                <?php if ($erro !== '')
                  echo generateAlertFieldErro($erro->getError('nPosition')); ?>

              </div>
            </div>

            <div class="row <?= $alocacao !== [] ? 'col-md-12' : 'col-6'; ?>">
              <div class="form-group col-6">
                <label for="exampleColorInput" class="form-label">Disciplinas :: </label>


                <?php foreach ($teacDisc as $item) : ?>
                  <div class="form-check form-switch">
                    <input class="form-check-input" name="nDisciplines[]" value="<?= $item->id; ?>" <?php echo set_checkbox('nDisciplines', $item->id); ?> type="checkbox" id="flexSwitchCheckDefault<?= $item->id; ?>">
                    <label class="form-check-label" for="flexSwitchCheckDefault<?= $item->id; ?>"> <?= $item->description; ?> </label>
                  </div>

                <?php endforeach ?>
                <?php if ($erro !== '')
                  echo generateAlertFieldErro($erro->getError('nDisciplines')); ?>


              </div>
              <div class="form-group">
                <label for="inputEmail3" class="col-form-label">Turno :: </label>

                <div class="form-check form-switch">
                  <input class="form-check-input" name="nShift[]" value="M" <?= set_checkbox('nShift', 'M'); ?> type="checkbox" role="switch" id="checboxShiftM">
                  <label class="form-check-label" for="checboxShiftM">MANHÃ</label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" name="nShift[]" value="T" <?= set_checkbox('nShift', 'T'); ?> type="checkbox" role="switch" id="checboxShiftT">
                  <label class="form-check-label" for="checboxShiftT">TARDE</label>
                </div>
                <?php if ($erro !== '')
                  echo generateAlertFieldErro($erro->getError('nShift')); ?>

              </div>

            </div>
          </div>
          <div class="card-footer">
            <?= generationButtonSave(); ?>
            <?= generateButtonClear(); ?>
            <?= generateButtonRetro('/teacDisc/list/' . $professor->id); ?>

          </div>
          </form>
        </div>
      </div>
      <?php if ($alocacao !== []) : ?>
        <div class="col-md-6">
          <div class="card card-dark">

            <div class="card-header">
              <h5 class="card-title font-weight-bold"> <i class="fa fa-user"></i> Alocação(ões) Realizada(s) :: </h5>
            </div>
            <div class="card-body table-responsive p-0" style="height: 530px;">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Dia :: </th>
                    <th scope="col">Disciplina :: </th>
                    <th scope="col">Posição ::</th>
                    <th scope="col">Situação ::</th>
                    <th scope="col">Turno ::</th>
                    <th scope="col">Ação :: </th>
                  </tr>
                </thead>
                <tbody>
                  <?php $contador = 1;
                  foreach ($alocacao as $data) : ?>
                    <tr>
                      <th class="align-middle" scope="row"><?= $contador++; ?></th>

                      <td class="align-middle text-center"><?= diaSemanaExtenso($data->dayWeek); ?></td>
                      <td class="align-middle text-center">
                        <div class="text-white" style="background-color:<?= ($data->color); ?>"><?= ($data->abbreviation); ?></div>
                      </td>
                      <td class="align-middle text-center"><?= $data->position . 'ª'; ?></td>
                      <td class="align-middle text-center">
                        <?= convertSituation($data->situation); ?>
                        <?php
                        if ($data->situation === 'O') {
                          $schedule = $scheduleModel->getScheduleByIdAllocation($data->id);
                          //dd($schedule);
                          echo '<span style="display:block" class="badge bg-secondary">' . $series->find($schedule->id_series)->description . 'ª Série</span>';
                        }
                        ?>
                      </td>
                      <td class="align-middle text-center"><?= turno($data->shift); ?></td>
                      <td class="align-middle text-center">
                        <?php if ($data->situation === 'L') : ?>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#basicModal<?= $data->id; ?>">
                            <i class="icons fas fa-trash"></i>
                          </button>
                        <?php else : ?>
                          <button type="button" class="btn btn-danger disabled">
                            <i class="icons fas fa-trash"></i>
                          <?php endif; ?>
                      </td>


                      <div class="modal fade" id="basicModal<?= $data->id; ?>" tabindex="-1" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header bg-danger">
                              <h5 class="modal-title">Excluir Alocação :: </h5>
                              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <?php
                            $atributos_formulario = array(
                              'role' => 'form',
                              'class' => ''
                            );
                            echo form_open('alocacao/delete', $atributos_formulario);

                            echo form_hidden('id', $data->id);
                            ?>
                            <div class="modal-body">
                              <div class="form-group col-12">
                                <h5>Confirmar a exclusão?</h5>
                              </div>

                            </div>
                            <div class="modal-footer">
                              <?= generationButtonSave('Confirmar'); ?>
                              <?= generateButtonCloseModal(); ?>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>


              <!-- End Default Table Example -->
            </div>
          </div>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>