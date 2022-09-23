<!-- Modal addTeacher -->
<div class="modal fade" id="addDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="addDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="addDisciplineModalLabel"><i class="fa fa-book"></i> Adicionar Disciplina ::</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertErrorDiscipline"></span>
                <?php echo form_open('discipline/create', ['id' => 'addDisciplineForm']);
           
                echo csrf_field()
                ?>
                <span id="checkAll"></span>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="description" class="form-label">Descrição :: </label>
                        <input class="form-control" id="description" name="description">
                        <span class="error invalid-feedback" id="fieldlertErrorDescriptionDiscipline"></span>
                    </div>
                    <div class="form-group col-6">
                        <label for="abbreviation" class="form-label">Abreviação :: </label>
                        <input class="form-control" id="abbreviation" name="abbreviation">
                        <span class="error invalid-feedback" id="fieldlertErrorAbbreviation"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="amount" class="form-label">Quantidade de aulas :: </label>
                        <input type ="number" min="1" max="10" class="form-control" id="amount" name="amount">
                        <span class="error invalid-feedback" id="fieldlertErrorAmount"></span>
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