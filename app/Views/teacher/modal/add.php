<!-- Modal addTeacher -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" role="dialog" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="addTeacherModalLabel"><i class="fa fa-user"></i> Adicionar Professor ::</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>
                <?php echo form_open('teacher/create', ['id' => 'addTeacherForm']);
                //echo form_hidden('id', $teacDisc->id);
                //echo form_hidden('_method', "put");
                //echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo csrf_field()
                ?>

                <div class="row">
                    <div class="form-group col-12">
                        <label for="inputNanme4" class="form-label">Nome Completo :: </label>
                        <input type="text" name="name" class="form-control" id="firstName" placeholder="Nome completo" value="<?= set_value('nNome') ?>" autofocus>
                        <span class="error invalid-feedback" id="fieldlertErrorname"></span>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                        <input type="number" min="1" max="45" name="amount" class="form-control" id="lastName" placeholder="Quantidade de aulas" value="<?= set_value('nNumeroAulas') ?>">
                        <span class="error invalid-feedback" id="fieldlertErroramount"></span>

                    </div>


                    <div class="form-group col-6">
                        <label for="exampleColorInput" class="form-label">Cor Destaque ::</label>
                        <input type="color" name="color" class="form-control form-control-color" id="exampleColorInput" value="<?= set_value('nCorDestaque', '#000000') ?>" title="Escolha uma cor">
                        <span class="error invalid-feedback" id="fieldlertErrorcolor"></span>

                    </div>
                </div>

                <div class="form-group col-12">
                    <label for="exampleColorInput" class="form-label">Disciplinas :: </label><br>
                    <?php foreach ($disciplinas as $item) : ?>
                        <div class="form-check-inline radio-toolbar text-white m-2 p-0" style="background-color:#2e5b8e; border-radius: 5px; margin: 5px; width: 120px;">

                            <!-- <div class="form-check-inline radio-toolbar text-white" style="background-color:#2e5b8e; border-radius: 5px; margin: 5px;"> -->
                            <input class="form-check-inline" name="disciplines" value="<?= $item->id; ?>" type="radio" id="flex<?= $item->id; ?>">
                            <label class="form-check-label" for="flex<?= $item->id; ?>">

                                <div class="d-flex">
                                    <div>
                                        <img src="<?= base_url(); ?>/assets/img/<?= $item->icone; ?>" width="28px" class="me-3 border-radius-lg p-1" alt="spotify">
                                    </div>
                                    <div class="my-auto">
                                        <h6 class="mb-0 text-sm"> <?= $item->abbreviation; ?></h6>
                                    </div>
                                </div>
                                <!-- <div class="rotulo"><span class="abbreviation font-weight-bold"><?php //$item->abbreviation; 
                                                                                                        ?></span>
                                    <span class="icon-delete"><i class="fa fa-book" aria-hidden="true"></i>
                                    </span>
                                </div> -->

                            </label>
                        </div>

                    <?php endforeach ?>

                    <span class="error invalid-feedback" id="fieldlertErrordisciplines"></span>

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