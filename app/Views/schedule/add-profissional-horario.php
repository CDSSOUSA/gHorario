<?php
echo $this->extend('layouts2/default');
echo $this->section('content'); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-secondary">

                    <div class="card-header">
                        <h3 class="card-title"><?=$title?></h3>
                    </div>

                    <?php echo form_open('horario/add') ?>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Professor :: (Clique para selecioná-lo)</label>
                            <br>
                            <?php foreach ($professores as $professor) : ?>
                                <div class="form-check form-check-inline radio-toolbar text-white" style="background-color:<?= $professor['color'] ?> ;">
                                    <input class="form-check-input" type="radio" id="gridCheck1<?= $professor['id'] ?>" name="nIdAlocacao" value="<?= $professor['id'] ?>">
                                    <label class="" for="gridCheck1<?= $professor['id'] ?>">
                                        <span class="font-size-12"><?= $professor['abbreviation']; ?></span><br><span class="font-size-10"><?= abbreviationTeacher($professor['name']); ?></span>
                                    </label>
                                </div>
                            <?php endforeach ?>
                            <div class="form-group col-4">
                                <label for="exampleInputPassword1">Dia Semana</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="<?= diaSemanaExtenso($diaSemana); ?>" disabled="true">
                                <input type="hidden" name="ndiaSemana" class="form-control" id="firstName" placeholder="" value="<?= $diaSemana; ?>">
                            </div>
                            <div class="form-group col-4">
                                <label for="exampleInputFile">Posição</label>
                                <input type="text" class="form-control" id="lastName" placeholder="" value="<?= $posicao . 'º' ?>" disabled="true">
                                <input type="hidden" class="form-control" name="nPosicao" placeholder="" value="<?= $posicao ?>">
                            </div>
                            <div class="form-group col-4">
                                <label for="exampleInputFile">Série</label>
                                <input type="text" class="form-control" value="<?= $idSerie->description . ' ' . $idSerie->classification . ' - ' . turno($idSerie->shift) ?>" id="zip" placeholder="" disabled="true">
                                <input type="hidden" name="nSerie" class="form-control" value="<?= $idSerie->id ?>">
                            </div>
                        </div>

                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
                <?= generateButtonRetro('/horario'); ?>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
<?= $this->endSection(); ?>