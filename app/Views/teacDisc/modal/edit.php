
<!-- Modal -->
<div class="modal fade" id="editTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="editTeacherDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="headerModal" class="modal-header">
                <h5 class="modal-title" id="editTeacherDisciplineModalLabel"><i class="fa fa-user"></i> Editar Disciplina/professor :: </h5>
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
                    

                    
                </div>

            </div>
            <div class="d-flex card-footer" style="width: 100%;">
                        <div class="text-left p-2" style="width: 70%; align-items: left;
  justify-content: left;">
                            <?= generationButtonSave(); ?>
                            <?= generateButtonCloseModal(); ?>
                        </div>
                        <div id="btnDelete" class="text-right p-2" style="width: 28%; align-items: rigth;
  justify-content: rigth;">

                        </div>

                    </div>
                    </form>
        </div>

    </div>
</div>