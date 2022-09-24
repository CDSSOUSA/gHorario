<!-- Modal deleteDiscipline -->
<div class="modal fade" id="delDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="delDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="delDisciplineModalLabel">Excluir Disciplina :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <span id="msgAlertErrorDisciplineDelete"></span>

                <?php echo form_open('discipline/del', ['id' => 'delDisciplineForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");
                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo csrf_field()
                ?>

                <div class="form-group col-6">

                    <input type="text" id="idDisciplineDel" name="id">
                    <label>Descrição ::</label>
                    <input type="text" id="descriptionDisciplineDel" disabled class="form-control">

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