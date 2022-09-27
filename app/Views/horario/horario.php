
<?php
use App\Models\DisciplineModel;

echo $this->extend('layouts2/default');
echo $this->section('content');
?>

<div id="load">
    <div id="loader">
    </div>
</div>
<div class="content-header">
    <div class="container-fluid">
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title; ?></h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary" aria-expanded="false">
                                    <i class="fa fa-cogs"></i> Consistência
                                </button>
                                &nbsp;&nbsp;
                                <button type="button" class="btn btn-sm btn-secondary" aria-expanded="false">
                                    <i class="fa fa-print"></i> Imprimir
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: auto;">
                        <table id="tb_schedule" class="table stripeeeee row-border order-column table-striped " style="width:100%">
                            <!-- <table class="table table-head-fixed text-nowrap table-striped"> -->
                            <thead class="table-primary">
                                <tr>
                                    <th class="align-middle">Dias</th>
                                    <th class="align-middle">Aulas</th>
                                    <?php
                                    $horario = $schoolSchedule;
                                    $discipline = new DisciplineModel();

                                    foreach ($series as $serie) : ?>
                                        <th class="text-center"><?= $serie->description . 'º ' . $serie->classification; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>                                
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
    </div>
</div>

<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="editTeacherDisciplineModalLabel">Adicionar horário :: <?= turno($shift); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <span id="msgAlertError"></span>
                <?php echo form_open('horario/api/create', ['id' => 'addScheduleForm']) ?>
                <div class="form-group col-12">
                    <label for="exampleInputFile">Escolha um(a) professor(a) :: </label>
                    <div id="divOpcao">
                    </div>
                    <span class="error invalid-feedback" id="fieldlertError"></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">
                                    Dados ::
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="callout callout-info">
                                    <h5 class="font-weight-bold"><i class="fa fa-th"></i> Série :: <span id="idSerieFake" class="info-box-number"></span> - <span id="shiftFake" class="info-box-number"></span></h5>

                                </div>

                                <div class="callout callout-info">
                                    <h5 class="font-weight-bold"><i class="fa fa-calendar"></i> <span id="positionFake" class="info-box-number"></span> Aula - <span id="dayWeekFake" class="info-box-number"></span></h5>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <span id="checkAll"></span>
                <input type="hidden" name="nSerie" id="idSerie">
                <input type="hidden" name="nDayWeek" id="dayWeek">
                <input type="hidden" name="nPosition" id="position">
                <input type="hidden" name="nShift" id="shift">
            </div>
            <div class="modal-footer">
                <?= generationButtonSave(); ?>
                <?= generateButtonCloseModal(); ?>

            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<!-- Modal delete-->
<div class="modal fade" id="deleteScheduleModal" tabindex="-1" aria-labelledby="deleteScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div id="load">
                <div id="loader"></div>
            </div>
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteScheduleModalLabel">Remover horário :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>

                <div class="d-flex m-1 p-2 b-radius-5 w-auto text-white" id="color">
                    <div id="image-disc">                       
                    </div>
                    <div class="my-auto">
                        <h6 id="disciplineDel" class="mb-0 text-sm font-weight-bold"></h6>
                        <!-- <span id="nameDel" class="mb-0 text-sm font-weight-bold"></span> -->
                        <!-- <span id="idSerieDel" class="mb-0 text-sm font-weight-bold"></span><br> -->
                        <span id="positonDel" class="mb-0 text-sm font-weight-bold"></span>
                        <span id="dayWeekDel" class="mb-0 text-sm font-weight-bold"></span>
                        <span id="shiftDel" class="mb-0 text-sm font-weight-bold"></span>
                    </div>
                </div>


                <!-- <div id="color" class="ticket-small">
                    <div class="rotulo">
                        <span id="disciplineDel" class="abbreviation font-weight-bold"></span>
                        <span class="icon-delete"><i class="fa fa-trash" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p id="nameDel" class="font-weight-bold"></p>
                    <hr>
                    <i class="fa fa-th"></i> <strong id="idSerieDel"></strong> - <strong id="shiftDel"></strong><br>
                    <i class="fa fa-calendar"></i> <strong id="positonDel"></strong>ª Aula - <strong id="dayWeekDel"></strong>
                </div> -->


                <?php echo form_open('horario/api/del', ['id' => 'deleteScheduleForm']) ?>
                <input type="hidden" id="idDelete" name="id" />

            </div>
            <div class="modal-footer">
                <?= generationButtonSave('Confirmar'); ?>
                <?= generateButtonCloseModal(); ?>

            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>