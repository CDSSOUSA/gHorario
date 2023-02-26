<!-- Modal deleteTeacherDiscipline -->
<div class="modal fade" id="deleteTeacherModal" tabindex="-1" role="dialog" aria-labelledby="deleteTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteTeacherModalLabel"><i class="fa fa-user"></i> Excluir professor ::</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php echo form_open('teacher/del', ['id' => 'deleteTeacherForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");
                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo csrf_field()
                ?>
                <div class="row col-6">
                    <label class="col-form-label">Nome completo :: <label class="col-form-label" id="nameTeacher"></label></label>
                    <!-- <input type="text" id="nameTeacher" disabled class="form-control"> -->
                    <input type="hidden" id="idDeleteTeacher" name="id">
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