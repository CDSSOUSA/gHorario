<!-- Modal deleteTeacherDiscipline -->
<div class="modal fade" id="deleteTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="deleteTeacherDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteTeacherDisciplineModalLabel">Excluir Disciplina/disciplina ::</h5>
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

                <div id="dataDeleteTeacDisc"></div>

                <div class="form-group col-6">
                    <input type="text" id="idDelete" name="id">

                </div>

            </div>

            <div class="modal-footer">
                <?= generationButtonSave('Confirmar'); ?>
                <?= generateButtonCloseModal(); ?>

                </form>
            </div>


        </div>
    </div>
</div>