<!-- Modal delete-->
<div class="modal fade" id="deleteScheduleModal" tabindex="-1" aria-labelledby="deleteScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div id="load">
                <div id="loader"></div>
            </div>
            <div id="headerScheduleRemove" class="modal-header">
                <h5 class="modal-title" id="deleteScheduleModalLabel"><i class="fa fa-th"></i> Remover horário :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>

                <div class="d-flex m-1 p-2 b-radius-5 w-auto text-white" id="color">
                    <div id="image-disc">                       
                    </div>
                    <div class="my-auto">
                        <h6 id="disciplineDel" class="mb-0 text-sm font-weight-bold"></h6>
                        <!-- <span id="nameDel" class="mb-0 text-sm font-weight-bold"></span> -->
                        <!-- <span id="idSerieDel" class="mb-0 text-sm font-weight-bold"></span><br> -->
                        <span id="positonDel" class="mb-0 text-sm font-weight-bold"></span>
                        <span id="dayWeekDel" class="mb-0 text-sm font-weight-bold"></span>
                        <span id="shiftDel" class="mb-0 text-sm font-weight-bold"></span>
                    </div>
                </div>


                <!-- <div id="color" class="ticket-small">
                    <div class="rotulo">
                        <span id="disciplineDel" class="abbreviation font-weight-bold"></span>
                        <span class="icon-delete"><i class="fa fa-trash" aria-hidden="true"></i>
                        </span>
                    </div>
                    <p id="nameDel" class="font-weight-bold"></p>
                    <hr>
                    <i class="fa fa-th"></i> <strong id="idSerieDel"></strong> - <strong id="shiftDel"></strong><br>
                    <i class="fa fa-calendar"></i> <strong id="positonDel"></strong>ª Aula - <strong id="dayWeekDel"></strong>
                </div> -->


                <?php echo form_open('horario/api/del', ['id' => 'deleteScheduleForm']) ?>
                <input type="hidden" id="idDelete" name="id" />

            </div>
            <div class="modal-footer">
                <?= generationButtonSave('Confirmar'); ?>
                <?= generateButtonCloseModal(); ?>

            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>