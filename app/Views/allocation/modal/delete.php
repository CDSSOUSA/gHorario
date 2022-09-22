<!-- Modal deleteAllocationTeacher -->
<div class="modal fade" id="delAllocationTeacherModal" tabindex="-1" role="dialog" aria-labelledby="delAllocationTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="delAllocationTeacherModalLabel">Excluir Alocação Professor :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php echo form_open('allocation/del', ['id' => 'delAllocationTeacherForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");
                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo csrf_field()
                ?>

                <div class="form-group col-6">
                    <div id="dataAllocation">

                    </div>
                    <input type="text" id="idAllocationDel" name="id">
                    <input type="text" id="id_teacher" name="id_teacher">

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