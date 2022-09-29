<?php
echo $this->extend('layouts2/default');
echo $this->section('content'); ?>
<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Horizontal Form</h5>
            <?php if ($msgs['alert']) : ?>
                <div class="alert alert-<?= $msgs['alert'] ?> bg-<?= $msgs['alert'] ?> text-light border-0 alert-dismissible fade show" role="alert">
                    <?= $msgs['message']; ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Horizontal Form -->
            <?php echo form_open('horario/add', ['class' => '']) ?>

            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Professor</label>
                <!--<div class="col-sm-9">
                    <select id="inputState" class="form-select" name="nIdAlocacao">
                        <option value="">Selecione ...</option>
                        <?php

                        // foreach ($professores as $professor) : 
                        ?>
                            <option value="<?php //$professor['id'] 
                                            ?>"><?php //abbreviationTeacher($professor['name']).' - '.$professor['abbreviation'] 
                                                ?></option>
                        <?php //endforeach 
                        ?>
                    </select>
                    <span style="color:red" class="font-italic font-weight-bold"><? php // echo $erro !== '' ? $erro->getError('nIdAlocacao') : ''; 
                                                                                    ?></span>

                </div>-->
                <div class="col-sm-9">


                    <?php

                    foreach ($professores as $professor) : ?>
                        <div class="form-check radio-toolbar text-white" style="background-color:<?= $professor['color'] ?> ;">
                            <input class="form-check-input" type="radio" id="gridCheck1<?= $professor['id'] ?>" name="nIdAlocacao" value="<?= $professor['id'] ?>">
                            <label class="form-check-label" for="gridCheck1<?= $professor['id'] ?>">
                                <?= abbreviationTeacher($professor['name']) . ' - ' . $professor['abbreviation'] ?>
                            </label>
                        </div>
                    <?php endforeach ?>

                    <span style="color:red" class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nIdAlocacao') : ''; ?></span>

                </div>
            </div>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-3 col-form-label">Dia Semana</label>
                <div class="col-sm-9">

                    <input type="text" class="form-control" id="firstName" placeholder="" value="<?= diaSemanaExtenso($diaSemana); ?>" disabled="true">
                    <input type="hidden" name="ndiaSemana" class="form-control" id="firstName" placeholder="" value="<?= $diaSemana; ?>">

                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Posição Aula</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="lastName" placeholder="" value="<?= $posicao . 'º' ?>" disabled="true">
                    <input type="hidden" class="form-control" name="nPosicao" placeholder="" value="<?= $posicao ?>">

                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-3 col-form-label">Série</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $idSerie['description'] . ' ' . $idSerie['classification'] . ' - ' . turno($idSerie['shift']) ?>" id="zip" placeholder="" disabled="true">
                    <input type="hidden" name="nSerie" class="form-control" value="<?= $idSerie['id'] ?>">
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
                <?= generateButtonRetro('/horario'); ?>
            </div>
            </form><!-- End Horizontal Form -->

        </div>
    </div>
</div>
<?= $this->endSection(); ?>