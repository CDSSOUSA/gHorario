<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title" id="editTeacherDisciplineModalLabel"><i class="fa fa-th"></i> Adicionar horário :: <?= turno($shift); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <span id="msgAlertError"></span>
                <?php echo form_open('horario/api/create', ['id' => 'addScheduleForm']) ?>
                <div class="form-group col-12">
                    <label for="exampleInputFile">Escolha um(a) professor(a) :: </label>
                    <div id="divOpcao">
                    </div>
                    <span class="error invalid-feedback" id="fieldlertError"></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title font-weight-bold">
                                    Dados ::
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="callout callout-info">
                                    <h5 class="font-weight-bold"><i class="fa fa-th"></i> Série :: <span id="idSerieFake" class="info-box-number"></span> - <span id="shiftFake" class="info-box-number"></span></h5>

                                </div>

                                <div class="callout callout-info">
                                    <h5 class="font-weight-bold"><i class="fa fa-calendar"></i> <span id="positionFake" class="info-box-number"></span> Aula - <span id="dayWeekFake" class="info-box-number"></span></h5>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <span id="checkAll"></span>
                <input type="hidden" name="nSerie" id="idSerie">
                <input type="hidden" name="nDayWeek" id="dayWeek">
                <input type="hidden" name="nPosition" id="position">
                <input type="hidden" name="nShift" id="shift">
            </div>
            <div class="modal-footer">
                <?= generationButtonSave(); ?>
                <?= generateButtonCloseModal(); ?>

            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>