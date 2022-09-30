<!-- Modal addTeacher -->
<div class="modal fade" id="addAllocationModal" tabindex="-1" role="dialog" aria-labelledby="addAllocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="heardAlocationModel" class="modal-header">
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
                    'type' => 'hidden'
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
                <div class="form-group col-12">
                        <label for="exampleColorInput" class="form-label">Dias/Aulas :: </label>
                   
                    <div class="card-body table-responsive p-0">
                        <table class="table">
                            <thead>
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center"> <a href="#" class="btn btn-outline-dark btn-sm" id="checkAll"><span><i class="fa fa-check-circle" title="Marcar todos"></i></span></a></th>
                                        <?php
                                        for ($dw = 2; $dw < 7; $dw++) { ?>
                                            <th class="text-center"><?= diaSemanaExtenso($dw); ?></th>
                                        <?php } ?>
                                    </tr>

                                </thead>
                            </thead>
                            <tbody>

                                <?php  //for ($dw = 2; $dw < 7; $dw++):
                                for ($ps = 1; $ps < 7; $ps++) : ?>
                                    <tr>
                                        <td class="align-middle text-center"><span class="text-gray"><?= $ps; ?>ª aula</span>
                                            </td>
                                        <?php for ($dw = 2; $dw < 7; $dw++) : ?>
                                            <td class="align-middle text-center">
                                           
                                                <input class="form-check-input checkbox" name="nDayWeek[]" value="<?= $ps; ?>;<?= $dw; ?>" type="checkbox" role="switch" id="dayWeek<?= $ps; ?><?= $dw; ?>">
                                                <label class="form-check-label" for="dayWeek<?= $ps; ?><?= $dw; ?>"></label>
                                            
                                            <?php endfor; ?>
                                    </tr>
                                <?php endfor;
                                //endfor;
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <span class="error invalid-feedback" id="fieldlertErrorDayWeek"></span>
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
                            <label class="form-check-label font-weight-bold text-sm" for="checboxShiftM">MANHÃ</label>
                            &nbsp;&nbsp;             
                            <input class="form-check-input checkbox" name="nShift[]" value="T" <?= set_checkbox('nShift', 'T'); ?> type="checkbox" role="switch" id="checboxShiftT">
                            <label class="form-check-label font-weight-bold text-sm" for="checboxShiftT">TARDE</label>
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