<?php

use App\Models\ProfessorDisciplinaModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>
<div class="row">
    <div class="col-12">
    <?php if ($msgs['alert']) : ?>
                <div class="alert alert-<?= $msgs['alert'] ?> bg-<?= $msgs['alert'] ?> text-light border-0 alert-dismissible fade show" role="alert">
                    <i class="fa fa-exclamation-triangle"></i><?= $msgs['message']; ?>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
                </div>
            <?php endif; ?>
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><?=$title;?> </h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

                <?php echo form_open('teacDisc/update'); 
                echo form_hidden('id', $teacDisc->id);
                echo form_hidden('_method', "put");
                echo form_hidden('id_teacher', $teacDisc->id_teacher);
                echo csrf_field() ?>
                
                <div class="card-body">
                    <div class="form-group col-6">
                        <label for="inputNanme4" class="form-label">Nome :: </label>
                        <input type="text" class="form-control" id="firstName" placeholder="Nome" value="<?= $nameTeacher ?>" disabled>
                        <span style="color:red" class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nNome') : ''; ?></span>
                    </div>
                    <div class="form-group col-6">
                        <label for="exampleColorInput" class="form-label">Disciplina :: </label>

                        <input type="text" disabled class="form-control" id="exampleColorInput" value="<?=$discipline;?>">
                        <span style="color:red" class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nDisciplina') : ''; ?></span>

                    </div>
                    <div class="row">
                    <div class="form-group col-3">
                        <label for="lastName" class="form-label">Quantidade de Aulas ::</label>
                        <input type="number" name="nNumeroAulas" class="form-control" id="lastName" placeholder="" value="<?=set_value('nNumeroAulas', $teacDisc->amount) ?>">
                        <span style="color:red" class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nNumeroAulas') : ''; ?></span>

                    </div>
                    <div class="form-group col-3">
                        <label for="exampleColorInput" class="form-label">Cor destaque</label>
                        <input type="color" name="nCorDestaque" class="form-control form-control-color" id="exampleColorInput" value="<?=set_value('nCorDestaque',$teacDisc->color);?>" title="Escolha uma cor">
                        <span style="color:red" class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nCorDestaque') : ''; ?></span>

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


<?= $this->endSection(); ?>