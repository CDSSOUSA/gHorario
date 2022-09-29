<!-- Modal editTeacher -->
<div class="modal fade" id="editDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="editDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title" id="editDisciplineModalLabel"><i class="fa fa-book"></i> Editar Disciplina ::</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertErrorDiscipline"></span>
                <?php echo form_open('discipline/update', ['id' => 'editDisciplineForm']);
           
                echo csrf_field()
                ?>
                <span id="checkAll"></span>
                <div class="row">
                    <div class="form-group col-6">
                        <input type="text" id="idDisciplineEdit" name="id" class="form-control">
                        <label for="description" class="form-label">Descrição :: </label>
                        <input class="form-control" id="descriptionDisciplineEdit" name="description">
                        <span class="error invalid-feedback" id="fieldlertErrorDescriptionDisciplineEdit"></span>
                    </div>
                    <div class="form-group col-6">
                        <label for="abbreviation" class="form-label">Abreviação :: </label>
                        <input class="form-control" id="abbreviationDisciplineEdit" name="abbreviation">
                        <span class="error invalid-feedback" id="fieldlertErrorAbbreviationEdit"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="amount" class="form-label">Quantidade de aulas :: </label>
                        <input type ="number" min="1" max="10" class="form-control" id="amountDisciplineEdit" name="amount">
                        <span class="error invalid-feedback" id="fieldlertErrorAmountEdit"></span>
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