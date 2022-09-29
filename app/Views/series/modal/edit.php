<!-- Modal -->
<div class="modal fade" id="editSerieModal" tabindex="-1" role="dialog" aria-labelledby="editSerieModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title" id="editSerieModalLabel"><i class="fa fa-users"></i> Editar Série :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertErrorEditSerie"></span>
                <?php echo form_open('series/update', ['id' => 'editSerieForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");
                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo csrf_field()
                ?>

                <input type="text" id="idSerieEdit" name="id">
                <div class="row">

                        <div class="form-group col-6">
                            <label for="description" class="form-label">Descrição :: </label>
                            <input type="text" name="description" class="form-control" id="descriptionEdit" placeholder=" Ex.: 6, 7, 8 ...">
                            <span class="error invalid-feedback" id="fieldlertErrordescription"></span>
                            <span class="error invalid-feedback" id="fieldlertDuplicative"></span>

                        </div>
                        <div class="form-group col-6">
                            <label for="description" class="form-label">Turma :: </label>
                            <input type="text" name="classification" class="form-control" id="classificationEdit" placeholder="Ex.: A,B,C ... " value="<?= set_value('classification') ?>">
                            <span class="error invalid-feedback" id="fieldlertErrorclassification"></span>

                        </div>
                    </div>      
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="description" class="form-label">Turno :: </label>
                            <select class="form-control" name="shift" id="shift">                               
                            </select>
                           <span class="error invalid-feedback" id="fieldlertErrorshift"></span>
                        </div>
                    </div>


            </div>
            <div class="modal-footer card-footer">
                    <?= generationButtonSave(); ?>
                    <?= generateButtonCloseModal(); ?>

                </div>
                </form>
        </div>

    </div>
</div>