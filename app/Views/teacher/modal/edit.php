<!-- Modal -->
<div class="modal fade" id="editTeacherModal" tabindex="-1" role="dialog" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title" id="editTeacherModalLabel"><i class="fa fa-user"></i> Editar Professor :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertErrorEditTeacher"></span>
                <?php echo form_open('teacher/update', ['id' => 'editTeacherForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");
                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo csrf_field()
                ?>

                <input type="text" id="idTeacherEdit" name="id">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="inputNanme4" class="form-label">Nome :: </label>
                        <input name="name" type="text" id="nameEdit" class="form-control" id="firstName" placeholder="Nome">
                        <span class="error invalid-feedback" id="fieldlertErrorEditName"></span>
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