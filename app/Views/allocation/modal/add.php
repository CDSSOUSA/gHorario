<!-- Modal addTeacher -->
<div class="modal fade" id="addAllocationModal" tabindex="-1" role="dialog" aria-labelledby="addAllocationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="addAllocationModalLabel"><i class="fa fa-user"></i> Adicionar Alocação ::</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertErrorAllocation"></span>
                <?php echo form_open('allocation/create', ['id' => 'addAllocationForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");

                echo form_input([
                    'id' => 'idTeacherAllocation',
                    'name' => 'id_teacher',
                    'type' => 'text'
                ]);
                echo csrf_field()
                ?>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="nameAllocation" class="form-label">Nome :: </label>
                        <input class="form-control" id="nameAllocation" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="inputEmail3" class="col-form-label" id="">Dia Semana :: <span id="checkAll"><i class="fa fa-check-double" title="Marcar todos"></i></span> </label>
                        <?php for ($i = 2; $i <= 6; $i++) : ?>

                            <div class="form-check custom-switch">
                                <input class="form-check-input checkbox" name="nDayWeek[]" value="<?= $i; ?>" <?= set_checkbox('nDayWeek', $i); ?> type="checkbox" role="switch" id="dayWeek<?= $i; ?>">
                                <label class="form-check-label" for="dayWeek<?= $i; ?>"><?= diaSemanaExtenso($i); ?></label>
                            </div>
                        <?php endfor; ?>
                        <span class="error invalid-feedback" id="fieldlertErrorDayWeek"></span>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-form-label">Posição Aula :: </label>
                        <?php
                        for ($i = 1; $i <= 6; $i++) : ?>
                            <div class="form-check form-switch">
                                <input class="form-check-input checkbox" name="nPosition[]" value="<?= $i; ?>" <?= set_checkbox('nPosition', $i); ?> type="checkbox" role="switch" id="checboxPosicao<?= $i; ?>">
                                <label class="form-check-label" for="checboxPosicao<?= $i; ?>"><?= $i . 'ª AULA'; ?></label>
                            </div>
                        <?php
                        endfor; ?>
                        <span class="error invalid-feedback" id="fieldlertErrorPosition"></span>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-12">
                        <label for="exampleColorInput" class="form-label">Disciplinas :: </label>

                        <div id="disc">
                        </div>
                        <span class="error invalid-feedback" id="fieldlertErrorDisciplines"></span>
                    </div>
                    <div class="form-group col-6">
                        <label for="inputEmail3" class="col-form-label">Turno :: </label>

                        <div class="form-check form-switch">
                            <input class="form-check-input checkbox" name="nShift[]" value="M" <?= set_checkbox('nShift', 'M'); ?> type="checkbox" role="switch" id="checboxShiftM">
                            <label class="form-check-label" for="checboxShiftM">MANHÃ</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input checkbox" name="nShift[]" value="T" <?= set_checkbox('nShift', 'T'); ?> type="checkbox" role="switch" id="checboxShiftT">
                            <label class="form-check-label" for="checboxShiftT">TARDE</label>
                        </div>
                        <span class="error invalid-feedback" id="fieldlertErrorShift"></span>

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