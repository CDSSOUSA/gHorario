<?php

use App\Models\HorarioModel;
use App\Models\DisciplineModel;

echo $this->extend('layouts2/default');
echo $this->section('content');
?>
<div id="load">
    <div id="loader">
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-th"></i> <?= $title; ?></h3>
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
                <table id="example" class="table stripeeeee row-border order-column table-striped " style="width:100%">
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
                        <?php
                        for ($dw = 2; $dw < 7; $dw++) :
                            for ($ps = 1; $ps < 7; $ps++) : ?>
                                <tr class="<?= $dw %  2 == 0 ? 'table-secondary' : 'table-success'; ?>">
                                    <th scope="row">
                                        <?php if ($ps == 1) : ?>
                                            <?= diaSemanaExtenso($dw); ?>
                                        <?php endif; ?>
                                    </th>

                                    <th><?= $ps . 'ª'; ?></th>
                                    <?php foreach ($series as $serie) :

                                        $datas = $horario->getTotalDiscBySerie($serie->id,);
                                        $ar = 0;
                                        $limits = [];
                                        if ($datas != null) {

                                            foreach ($datas as $d) {

                                                $limit = $discipline->getLimitClassroom($d->id);
                                                if ($limit->amount <= $d->total) {
                                                    $limits[] = $d->id;
                                                }
                                            }
                                            if ($limits != null) {

                                                //$data = $this->allocation->getAllocationByDayWeek($idSerie, $dayWeek, $position, $shift, $limits);
                                                $allocationDisponivel = $allocation->getAllocationByDayWeek($serie->id, $dw, $ps, $shift, $limits);
                                            } else {

                                                //$data = $this->allocation->getAllocationByDayWeekA($idSerie, $dayWeek, $position, $shift);
                                                $allocationDisponivel = $allocation->getAllocationByDayWeekA($serie->id, $dw, $ps, $shift);
                                            }
                                        } else {

                                            //$data = $this->allocation->getAllocationByDayWeekA($idSerie, $dayWeek, $position, $shift);
                                            $allocationDisponivel = $allocation->getAllocationByDayWeekA($serie->id, $dw, $ps, $shift);
                                        }

                                        //$allocationDisponivel = $allocation->getAllocationByDayWeekA($serie->id, $dw, $ps, $shift);


                                        //dd($allocationDisponivel);
                                        $horarioSegundas = $horario->getTimeDayWeek($dw, $serie->id, $ps);

                                        //$qtde = $teacherDiscipline->getTeacherDisciplineByIdTeacher($allocationDisponivel['id_teacher']);

                                        //dd(count($qtde));
                                        // if (!empty($horarioSegundas['id_allocation'])) {

                                        //     $a = $allocation->getTeacherByIdAllocation($horarioSegundas['id_allocation']);
                                        //     //dd($a);
                                        // }

                                    ?>
                                        <td class="text-left">
                                            <?php
                                            if ($allocationDisponivel != null && empty($horarioSegundas['id_allocation'])) {
                                                echo anchor('#', '<div class="rotulo"><span class="abbreviation"><i class="icons fas fa-book"></i> </span>
                                                                    <span class="icon-delete"><i class="fa fa-plus"></i></span></div><p>DISPONÍVEL</p>', ['onclick' => 'addSchedule(' . $serie->id . ',' . $ps . ',' . $dw . ',"' . $shift . '")', 'data-toggle' => 'modal', 'class' => 'btn btn-dark btn-sm ticket text-left']);

                                                //echo anchor('horario/add_profissional_horario/' . $serie->id . '/' . $dw . '/' . $ps, "DISPONÍVEL", array('type' => 'button', 'class' => 'btn btn-success btn-sm ticket text-center'));
                                            } else
                                                if (empty($horarioSegundas['id_allocation'])) { ?>

                                                <div class="ticket-vague">
                                                    <div class="rotulo">
                                                        <span>VAGO</span>
                                                        <span class="icon-vaguo"><i class="fa fa-lock"></i></span>
                                                    </div>
                                                    <p>SEM PROFESSOR</p>
                                                </div>
                                            <?php
                                            } else { ?>
                                                <div style="background-color:<?= $horarioSegundas['color'] ?>" class="ticket">
                                                    <?php
                                                    echo anchor(
                                                        '#',
                                                        '<div class="rotulo"><span class="abbreviation">' . $horarioSegundas['abbreviation'] . '</span>
                                                                        <span class="icon-delete"><i class="fa fa-trash"></i></span></div>
                                                <p>' . abbreviationTeacher($horarioSegundas['name']) . '</p>',
                                                        array('type' => 'button', 'class' => 'text-white', 'onclick' => 'deleteSchedule(' . $horarioSegundas['id'] . ')', 'data-toggle' => 'modal', 'title' => 'Remover do horário?')
                                                    );
                                                    //                     echo anchor(
                                                    //                         'horario/api/delete/' . $serie->id . '/' . $dw . '/' . $ps,
                                                    //                         '<div class="rotulo"><span class="abbreviation">' . $horarioSegundas['abbreviation'] . '</span>
                                                    //                         <span class="icon-delete"><i class="fa fa-trash"></i></span></div>
                                                    // <p>' . abbreviationTeacher($horarioSegundas['name']) . '</p>',
                                                    //                         array('type' => 'button', 'class' => 'text-white')
                                                    //                     );
                                                    ?>
                                                </div>

                                            <?php } ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                        <?php endfor;
                        endfor; ?>
                    </tbody>
                </table>
                <!-- End Default Table Example -->
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
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

                
                <div class="form-group col-3">

                    <label for="exampleInputFile">Série :: </label>
                    <input type="hidden" name="nSerie" id="idSerie" class="form-control">
                    <input type="text" name="" id="idSerieFake" class="form-control" disabled>

                </div>

                <div class="form-group col-3">

                    <label for="exampleInputFile">Posição :: </label>
                    <input type="text" name="nPosition" id="position" class="form-control">

                </div>
                <div class="form-group col-3">

                    <label for="exampleInputFile">Dia semana :: </label>
                    <input type="hidden" name="nDayWeek" id="dayWeek">
                    <input type="text" name="" id="dayWeekFake" class="form-control" disabled>

                </div>
                <div class="form-group col-3">

                    <label for="exampleInputFile">Turno :: </label>
                    <input type="text" name="nShift" id="shift" class="form-control">

                </div>
                </div>

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
                <h5 class="modal-title" id="deleteScheduleModalLabel">Remover horário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>
                <?php echo form_open('horario/api/del', ['id' => 'deleteScheduleForm']) ?>

                <div class="form-group col-12">
                    <input type="text" id="idDelete" name="id" />
                    <p>Confirmar remoção?</p>
                </div>

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