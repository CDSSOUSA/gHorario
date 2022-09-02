<?php

use App\Models\HorarioModel;

echo $this->extend('layouts2/default');
echo $this->section('content');
?>
<div id="load">
    <div id="loader">
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><?= $title; ?></h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 1000px;">
                <table class="table table-head-fixed text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>Dias</th>
                            <th>Aulas</th>
                            <?php
                            $horario = $schoolSchedule;

                            foreach ($series as $serie) : ?>
                                <th class="text-center"><?= $serie->description . 'º ' . $serie->classification; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($dw = 2; $dw < 7; $dw++) :
                            for ($ps = 1; $ps < 7; $ps++) : ?>
                                <tr>
                                    <th scope="row">
                                        <?php if ($ps == 1) : ?>
                                            <?= diaSemanaExtenso($dw); ?>
                                        <?php endif; ?>
                                    </th>
                                    <th><?= $ps . 'º'; ?></th>
                                    <?php foreach ($series as $serie) :
                                        $allocationDisponivel = $allocation->getAllocationByDayWeek($serie->id, $dw, $ps);


                                        //dd($allocationDisponivel);
                                        $horarioSegundas = $horario->getTimeDayWeek($dw, $serie->id, $ps);

                                        //$qtde = $teacherDiscipline->getTeacherDisciplineByIdTeacher($allocationDisponivel['id_teacher']);

                                        //dd(count($qtde));
                                        if (!empty($horarioSegundas['id_allocation'])) {

                                            $a = $allocation->getTeacherByIdAllocation($horarioSegundas['id_allocation']);
                                            //dd($a);
                                        }

                                    ?>
                                        <td class="text-left"><?php
                                                                if ($allocationDisponivel != null && empty($horarioSegundas['id_allocation'])) {
                                                                    echo anchor('#', '<div class="rotulo"><span><i class="icons fas fa-book"></i> </span>
                                                                    <span class="icon-delete"><i class="fa fa-plus"></i></span></div><p>DISPONÍVEL</p>', ['onclick' => 'addSchedule(' . $serie->id . ',' . $ps . ',' . $dw . ')', 'data-toggle' => 'modal', 'class' => 'btn btn-dark btn-sm ticket text-left']);

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


                </table>
            </div>

        </div>

    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="editTeacherDisciplineModalLabel">Adicionar horário</h5>
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
                <div class="form-group col-4">

                    <label for="exampleInputFile">Série :: </label>
                    <input type="text" name="nSerie" id="idSerie" class="form-control">

                </div>

                <div class="form-group col-4">

                    <label for="exampleInputFile">Posição :: </label>
                    <input type="text" name="nPosition" id="position" class="form-control">

                </div>
                <div class="form-group col-4">

                    <label for="exampleInputFile">Dia semana :: </label>
                    <input type="text" name="nDayWeek" id="dayWeek" class="form-control">

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