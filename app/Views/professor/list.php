<?php

use App\Models\ProfessorDisciplinaModel;
use App\Models\TeacDiscModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>

<div class="row">
    <div class="col-12">
        <span id="msgAlertSuccess"></span>
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><?= $title; ?> </h3>
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
                            <th>#</th>
                            <th>Nome :: </th>
                            <th>Disciplina(s)/ Qtde aula(s) ::</th>                            
                            <th>Qtde total aulas :: </th>
                            <th>Ação :: </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1;
                        foreach ($teachers as $data) : ?>
                            <tr>
                            <td class="align-middle"><?= $contador++; ?></td>
                                <td class="align-middle"><?= $data->name; ?></td>
                                <td width="20px">
                                    <?php
                                    $disciplines = new TeacDiscModel();
                                    $disciplinesTeacher = $disciplines->getTeacherDisciplineByIdTeacher($data->id);
                                    foreach ($disciplinesTeacher as $item) : ?>
                                        <div class="m-2 p-2 font-weight-bold" style="background-color:<?= $item->color; ?>; color:white">
                                        <i class="icons fas fa-book"></i> <?=$item->abbreviation; ?> :: <?=$item->amount;?>
                                    </div>                                        
                                    <?php endforeach; ?>
                                </td> 
                                <td class="align-middle text-center"><?=$data->amount;?></td>                                                           

                                <td class="align-middle">
                                    <!-- Button trigger modal -->

                                    <?= anchor('/teacDisc/list/'.$data->id, '<i class="icons fas fa-book"></i> Adicionar Disciplina', ['class' => 'btn btn-dark']); ?>
                                    <?php //anchor('#', '<i class="icons fas fa-pen"></i> Editar professor', ['data-bs-toggle' => 'modal', 'class' => 'btn btn-dark']); ?>
                                    <?php 
                                    if(count($disciplinesTeacher)>=1){
                                        echo anchor('alocacao/add/' . $data->id, '<i class="icons fas fa-calendar"></i> Adicionar Alocação', ['class' => 'btn btn-dark']);

                                    } ?> 
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="editTeacherDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title" id="editTeacherDisciplineModalLabel">Editar Professor/Disciplina</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
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


                <div class="form-group col-6">
                    <input type="text" id="id" name="id">
                    <label for="inputNanme4" class="form-label">Nome :: </label>
                    <input type="text" id="id_teacher" class="form-control" id="firstName" placeholder="Nome" value="<?php //$nameTeacher 
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

                <div class="form-group col-6">
                    <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                    <input type="number" id="numeroAulas" name="nNumeroAulas" class="form-control" id="lastName" placeholder="" value="<?php //set_value('nNumeroAulas', $teacDisc->amount) 
                                                                                                                                        ?>">
                    <span class="error invalid-feedback" id="fieldlertError"></span>

                </div>
                <div class="form-group col-3">
                    <label for="exampleColorInput" class="form-label">Cor destaque</label>
                    <input type="color" id="corDestaque" name="nCorDestaque" class="form-control form-control-color" id="exampleColorInput" value="<?php //set_value('nCorDestaque',$teacDisc->color);
                                                                                                                                                    ?>" title="Escolha uma cor">
                    <span style="color:red" class="font-italic font-weight-bold"><?php //echo $erro !== '' ? $erro->getError('nCorDestaque') : ''; 
                                                                                    ?></span>

                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>

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
<?= $this->endSection(); ?>