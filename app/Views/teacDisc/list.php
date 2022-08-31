<?php

use App\Models\AllocationModel;
use App\Models\ProfessorDisciplinaModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>

<div class="row">
    <div class="col-12">
        <?php if ($msgs['alert']) : ?>
            <div class="alert alert-<?= $msgs['alert'] ?> bg-<?= $msgs['alert'] ?> text-light border-0 alert-dismissible fade show" role="alert">
                <?= $msgs['salutation']; ?>
                <?= $msgs['message']; ?>
                <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        endif;
        session()->remove('success'); ?>
        <span id="msgAlertSuccess"></span>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><?= $title ?></h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <?php
                        $total = count($disciplines->findAll());
                        $totalTeacDisc = count($teacDisc);
                        if ($total > $totalTeacDisc)
                            echo anchor('#', '<i class="icons fas fa-plus"></i> Nova Disciplina', ['onclick' => 'addTeacherDiscipline(' . $dataTeacher->id . ')', 'data-bs-toggle' => 'modal', 'class' => 'btn btn-secondary']); ?>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-nowrap table-striped">
                    <thead>
                        <tr>
                            <th colspan="5">
                                <h5>Nome:: <?= $dataTeacher->name; ?></h5>
                            </th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Cor destaque :: </th>
                            <th>Disciplina(s) :: </th>
                            <th class="text-center">Qtde aulas :: </th>
                            <th class="text-center">Ação :: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1;
                        foreach ($teacDisc as $data) : ?>
                            <tr>
                                <td><?= $contador++; ?></td>
                                <td>
                                    <div style="background-color:<?= $data->color; ?>; color:transparent">.</div>
                                </td>
                                <td><?= $data->description; ?></td>
                                <td class="text-center"><?= $data->amount; ?></td>

                                <td class="text-center">
                                    <!-- Button trigger modal -->

                                    <?= anchor('#', '<i class="icons fas fa-pen"></i> Editar', ['onclick' => 'editTeacherDiscipline(' . $data->id . ')', 'data-bs-toggle' => 'modal', 'class' => 'btn btn-dark']); ?>
                                    <?php  
                                     $allacation = new AllocationModel();
                                     $total = $allacation->getCountByIdTeacDisc($data->id);
                                     //dd($total);
                                    if($total <= 0){

                                        echo anchor('#', '<i class="icons fas fa-trash"></i> Excluir', ['onclick' => 'delTeacherDiscipline(' . $data->id . ')', 'data-bs-toggle' => 'modal', 'class' => 'btn btn-dark']);
                                    } else { ?>
                                        <button type="buttton" class="btn btn-dark disabled"><i class="icons fas fa-trash"></i> Excluir</button>
                                        
                                    <?php } ?>
                                    
                                    <?php echo anchor('alocacao/add/' . $data->id_teacher, '<i class="icons fas fa-plus"></i> Alocação', ['class' => 'btn btn-dark']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <?= generateButtonRetro('/professor/list'); ?>
        </div>
    </div>
</div>

<!-- Modal add-->
<div class="modal fade" id="addTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark font-weight-bold">
                <h5 class="modal-title" id="addTeacherDisciplineModal">Cadastrar Professor/Disciplina :: </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
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
                    'type' => 'hidden'
                ]);
                echo csrf_field()
                ?>
                <div class="form-group col-6">
                    <label for="exampleColorInput" class="form-label">Disciplinas :: </label>

                    <?php
                    $myDiscipline = [];
                    foreach ($teacDisc as $a) {
                        $myDiscipline[] = $a->id_discipline;
                    }
                    foreach ($disciplines->findAll() as $item) :
                        if (!in_array($item->id, $myDiscipline)) : ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="nDisciplinas[]" value="<?= $item->id; ?>" <?php echo set_checkbox('nDisciplinas', $item->id); ?> type="checkbox" id="flexSwitchCheckDefault<?= $item->id; ?>">
                                <label class="form-check-label" for="flexSwitchCheckDefault<?= $item->id; ?>"> <?= $item->description; ?> </label>
                            </div>

                    <?php endif;

                    endforeach ?>
                    <span style="color:red" class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nDisciplinas') : ''; ?></span>


                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                        <input type="number" min="1" max="30" name="nNumeroAulas" class="form-control" id="qtdeAulas" placeholder="" value="<?= set_value('nNumeroAulas') ?>">
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
<!-- Modal edit-->
<div class="modal fade" id="editTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="editTeacherDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="editTeacherDisciplineModalLabel">Editar Professor/Disciplina ::</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>
                <?php echo form_open('teacDisc/update', ['id' => 'editTeacherDiscipline']);
                echo csrf_field();
                echo form_input([
                    'id' => 'idEdit',
                    'name' => 'id', 'type' => 'hidden'
                ]);
                ?>
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
                        <input type="number" min="1" max="30" id="numeroAulas" name="nNumeroAulas" class="form-control" id="lastName" placeholder="" value="<?php //set_value('nNumeroAulas', $teacDisc->amount) 
                                                                                                                                                            ?>">
                        <span class="error invalid-feedback" id="fieldlertError"></span>

                    </div>
                    <div class="form-group col-6">
                        <label for="exampleColorInput" class="form-label">Cor destaque</label>
                        <input type="color" id="corDestaque" name="nCorDestaque" class="form-control form-control-color" id="exampleColorInput" value="<?php //set_value('nCorDestaque',$teacDisc->color);
                                                                                                                                                        ?>" title="Escolha uma cor">
                        <span style="color:red" class="font-italic font-weight-bold"><?php //echo $erro !== '' ? $erro->getError('nCorDestaque') : ''; 
                                                                                        ?></span>
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

<!-- Modal delete -->
<div class="modal fade" id="deleteTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="deleteTeacherDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteTeacherDisciplineModalLabel">Excluir Professor/Disciplina ::</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('teacDisc/del', ['id' => 'deleteTeacherDisciplineForm']);
            echo csrf_field();
            echo form_input([
                'id' => 'idDelete',
                'type' => 'hidden',
                'name' => 'id'
            ]);
            ?>
            <div class="modal-body">

                <div class="form-group col-6">
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
<?= $this->endSection(); ?>