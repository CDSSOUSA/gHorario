<?php

use App\Models\ProfessorDisciplinaModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php if ($msgs['alert']) : ?>
                    <div class="alert alert-<?= $msgs['alert'] ?> bg-<?= $msgs['alert'] ?> text-light border-0 alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle"></i><?= $msgs['message']; ?>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php 
                endif;
                session()->remove('success'); ?>
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><?= $title ?></h3>
                    </div>
                    
                    <?php echo form_open('professor/create') ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="inputNanme4" class="form-label">Nome Completo :: </label>
                                <input type="text" name="nNome" class="form-control" id="firstName" placeholder="Nome completo" value="<?= set_value('nNome') ?>" autofocus>
                                <?php if($erro !== '')                              
                                echo generateAlertFieldErro($erro->getError('nNome'));?>


                            </div>
                            <div class="form-group col-6">
                                <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                                <input type="number" min="1" max="30" name="nNumeroAulas" class="form-control" id="lastName" placeholder="Quantidade de aulas" value="<?= set_value('nNumeroAulas') ?>">
                                <?php if($erro !== '')                              
                                echo generateAlertFieldErro($erro->getError('nNumeroAulas'));?>


                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4">
                                <label for="exampleColorInput" class="form-label">Cor Destaque ::</label>
                                <input type="color" name="nCorDestaque" class="form-control form-control-color" id="exampleColorInput" value="<?= set_value('nCorDestaque', '#CCCCCC') ?>" title="Escolha uma cor">
                                <?php if($erro !== '')                              
                                echo generateAlertFieldErro($erro->getError('nCorDestaque'));?>

                            </div>
                            <div class="form-group col-8">
                                <label for="exampleColorInput" class="form-label">Disciplinas :: </label>

                                <?php foreach ($disciplinas as $item) : ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="nDisciplinas[]" value="<?= $item->id; ?>" <?php echo set_checkbox('nDisciplinas', $item->id); ?> type="checkbox" id="flexSwitchCheckDefault<?= $item->id; ?>">
                                        <label class="form-check-label" for="flexSwitchCheckDefault<?= $item->id; ?>"> <?= $item->description; ?> </label>
                                    </div>

                                <?php endforeach ?>
                                <?php if($erro !== '')                              
                                echo generateAlertFieldErro($erro->getError('nDisciplinas'));?>

                            </div>
                        </div>
                        <hr>
                        <div class="card-footer">
                            <?= generationButtonSave(); ?>
                            <?= generateButtonClear(); ?>
                            <?= generateButtonRetro('/horario'); ?>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>