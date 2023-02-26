<!-- Model add teacher disciplina-->
<div class="modal fade" id="addTeacherDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white font-weight-bold bg-default-discipline">
                <h5 class="modal-title" id="addTeacherDisciplineModal"><i class="fa fa-user"></i> Cadastrar Disciplina/professor :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertErrorTeacDisc"></span>
                <?php echo form_open('teacDisc/create', ['id' => 'addTeacherDisciplineForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");
                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo form_input([
                    'id' => 'idTeac',
                    'name' => 'id_teacher',
                    'type' => 'hidden'
                ]);
                echo form_input([
                    'name' => 'status',
                    'type' => 'hidden',
                    'value' => 'A'
                ]);
                echo csrf_field()
                ?>
                <div class="row">
                    <div class="form-group col-6">
                        <!-- <label for="nameDiscipline" class="form-label">Nome :: </label> -->
                        <label class="col-form-label">Nome completo :: <label class="col-form-label" id="nameDiscipline"></label></label>
                        <!-- <input class="form-control" id="nameDiscipline" disabled> -->
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="exampleColorInput" class="form-label">Disciplinas :: </label><br>


                    <?php foreach ($disciplinas as $item) : ?>
                        <div class="form-check-inline radio-toolbar text-white m-2 p-0" style="background-color:#2e5b8e; border-radius: 5px; margin: 5px; width: 120px;">
                            <input class="form-check-inline" name="disciplinesTeacher" value="<?= $item->id; ?>" type="radio" id="flexSwitchCheck<?= $item->id; ?>">
                            <label class="form-check-label" for="flexSwitchCheck<?= $item->id; ?>">
                                <div class="d-flex">
                                    <div >
                                        <img src="<?= base_url(); ?>/assets/img/<?= $item->icone; ?>" width="28px" class="me-3 border-radius-lg p-1" alt="spotify">
                                    </div>
                                    <div class="my-auto">
                                        <h6 class="mb-0 text-sm"> <?= $item->abbreviation; ?></h6>
                                    </div>
                                </div>
                            </label>
                        </div>





                    <?php endforeach ?>

                    <span class="error invalid-feedback" id="fieldlertErrordisciplinesTechDisc"></span>

                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                        <input type="number" min="1" max="45" name="amount" class="form-control" id="amount" placeholder="Quantidade de aulas" value="<?= set_value('amount') ?>">
                        <span class="error invalid-feedback" id="fieldlertErroramountTechDisc"></span>
                    </div>
                    <div class="form-group col-6">
                        <label for="exampleColorInput" class="form-label">Cor Destaque :: </label>
                        <input type="color" name="color" class="form-control form-control-color" id="color" value="nCorDestaque" title="Escolha uma cor">
                        <span class="error invalid-feedback" id="fieldlertErrorcolorTechDisc"></span>
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