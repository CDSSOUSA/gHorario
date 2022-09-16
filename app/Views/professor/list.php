<?php

use App\Models\ProfessorDisciplinaModel;
use App\Models\TeacDiscModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>
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
            <div class="col-12">
                <span id="msgAlertSuccess"></span>
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><?= $title ?></h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <?php
                                echo anchor('#', '<i class="icons fas fa-plus"></i> Novo professor', ['onclick' => 'addTeacher()', 'data-toggle' => 'modal', 'class' => 'btn btn-secondary']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: 1000px;">

                        <table id="tb_teacher" class="table table-head-fixed text-nowrap table-striped">

                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Nome :: </th>
                                    <th>Disciplina(s) / Qtde aula(s) :: </th>
                                    <!-- <th>Qtde total aulas :: </th> -->
                                    <th>Ação :: </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="addTeacherModalLabel"><i class="fa fa-user"></i> Adicionar Professor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="msgAlertError"></span>
                        <?php echo form_open('teacher/create', ['id' => 'addTeacherForm']);
                        //echo form_hidden('id', $teacDisc->id);
                        //echo form_hidden('_method', "put");
                        //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                        echo csrf_field()
                        ?>

                        <div class="row">
                            <div class="form-group col-12">
                                <label for="inputNanme4" class="form-label">Nome Completo :: </label>
                                <input type="text" name="name" class="form-control" id="firstName" placeholder="Nome completo" value="<?= set_value('nNome') ?>" autofocus>
                                <span class="error invalid-feedback" id="fieldlertErrorname"></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                                <input type="number" min="1" max="45" name="amount" class="form-control" id="lastName" placeholder="Quantidade de aulas" value="<?= set_value('nNumeroAulas') ?>">
                                <span class="error invalid-feedback" id="fieldlertErroramount"></span>

                            </div>


                            <div class="form-group col-6">
                                <label for="exampleColorInput" class="form-label">Cor Destaque ::</label>
                                <input type="color" name="color" class="form-control form-control-color" id="exampleColorInput" value="<?= set_value('nCorDestaque', '#000000') ?>" title="Escolha uma cor">
                                <span class="error invalid-feedback" id="fieldlertErrorcolor"></span>

                            </div>
                        </div>

                        <div class="form-group col-8">
                            <label for="exampleColorInput" class="form-label">Disciplinas :: </label>

                            <?php foreach ($disciplinas as $item) : ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="disciplines[]" value="<?= $item->id; ?>" <?php echo set_checkbox('nDisciplinas', $item->id); ?> type="checkbox" id="flexSwitchCheckDefault<?= $item->id; ?>">
                                    <label class="form-check-label" for="flexSwitchCheckDefault<?= $item->id; ?>"> <?= $item->description; ?> </label>
                                </div>

                            <?php endforeach ?>
                            <span class="error invalid-feedback" id="fieldlertErrordisciplines"></span>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <?= generationButtonSave(); ?>
                        <?= generateButtonCloseModal(); ?>

                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="addTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark font-weight-bold">
                <h5 class="modal-title" id="addTeacherDisciplineModal">Cadastrar Professor/Disciplina :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>
                <?php echo form_open('teacDisc/create', ['id' => 'addTeacherDisciplineForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");
                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo form_input([
                    'id' => 'id',
                    'name' => 'id_teacher',
                    'type' => 'text'
                ]);
                echo csrf_field()
                ?>
                <div class="form-group col-6">

                    <label for="exampleColorInput" class="form-label">Disciplinas :: <span id="checkAll"><i class="fa fa-check-double" title="Marcar todos"></i></span> </label>
                    <div id="disciplines">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                        <input type="number" min="1" max="45" name="nNumeroAulas" class="form-control" id="qtdeAulas" placeholder="" value="<?= set_value('nNumeroAulas') ?>">
                        <span class="error invalid-feedback" id="fieldlertError"></span>
                    </div>
                    <div class="form-group col-6">
                        <label for="exampleColorInput" class="form-label">Cor Destaque :: </label>
                        <input type="color" name="nCorDestaque" class="form-control form-control-color" id="color" value="nCorDestaque" title="Escolha uma cor">
                        <span style="color:red" class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nCorDestaque') : ''; ?></span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <?= generationButtonSave(); ?>
                <?= generateButtonCloseModal(); ?>
            </div>
            </form>
        </div>
    </div>
</div>

        <!-- Modal -->
        <div class="modal fade" id="editTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="editTeacherDisciplineModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title" id="editTeacherDisciplineModalLabel">Editar Professor/Disciplina :: </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="msgAlertError"></span>
                        <?php echo form_open('teacDisc/update', ['id' => 'editTeacherDiscipline']);
                        //echo form_hidden('id', $teacDisc->id);
                        //echo form_hidden('_method', "put");
                        //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                        echo csrf_field()
                        ?>

                        <input type="text" id="idEdit" name="id">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="inputNanme4" class="form-label">Nome :: </label>
                                <input type="text" id="nameEdit" class="form-control" id="firstName" placeholder="Nome" value="<?php //$nameTeacher 
                                                                                                                                ?>" disabled>
                                <span style="color:red" class="font-italic font-weight-bold"><?php //echo $erro !== '' ? $erro->getError('nNome') : ''; 
                                                                                                ?></span>
                            </div>
                            <div class="form-group col-6">
                                <label for="exampleColorInput" class="form-label">Disciplina :: </label>

                                <input type="text" id="id_discipline" disabled class="form-control" id="exampleColorInput" value="<?php //$discipline;
                                                                                                                                    ?>">
                                <span style="color:red" class="font-italic font-weight-bold"><?php //echo $erro !== '' ? $erro->getError('nDisciplina') : ''; 
                                                                                                ?></span>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                                <input type="number" min="1" max="40" id="numeroAulas" name="nNumeroAulas" class="form-control" id="lastName" placeholder="" value="<?php //set_value('nNumeroAulas', $teacDisc->amount) 
                                                                                                                                                    ?>">
                                <span class="error invalid-feedback" id="fieldlertError"></span>

                            </div>
                            <div class="form-group col-6">
                                <label for="exampleColorInput" class="form-label">Cor destaque :: </label>
                                <input type="color" id="corDestaque" name="nCorDestaque" class="form-control form-control-color" id="exampleColorInput" value="<?php //set_value('nCorDestaque',$teacDisc->color);
                                                                                                                                                                ?>" title="Escolha uma cor">
                                <span style="color:red" class="font-italic font-weight-bold"><?php //echo $erro !== '' ? $erro->getError('nCorDestaque') : ''; 
                                                                                                ?></span>

                            </div>
                            <div class="row">
                            </div>

                            <div class="modal-footer">
                                <?= generationButtonSave(); ?>
                                <?= generateButtonCloseModal(); ?>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="deleteTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="deleteTeacherDisciplineModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title" id="deleteTeacherDisciplineModalLabel">Excluir Professor/disciplina</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <?php echo form_open('teacDisc/del', ['id' => 'deleteTeacherDisciplineForm']);
                                //echo form_hidden('id', $teacDisc->id);
                                //echo form_hidden('_method', "put");
                                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                                echo csrf_field()
                                ?>


                                <div class="form-group col-6">
                                    <input type="text" id="idDelete" name="id">
                                    <p>Desejar realmente excluir?</p>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <?= generateButtonRetro('/horario'); ?>

                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->endSection(); ?>