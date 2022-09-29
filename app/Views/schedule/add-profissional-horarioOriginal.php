<?php
 echo $this->extend('layouts/default'); ?>
<?= $this->section('content');?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><?php echo anchor('/horario','<button type="button" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
</svg>
              </button>'); echo ' '.$title;?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
            </button>
        </div>
    </div>
    <div class="row g-5">
        <div class="col-md-7 col-lg-8">
            <div class=" border-left-<?=$msgs['alert']?> alert alert-show alert-<?=$msgs['alert']?>">
                <strong><?=$msgs['message'];?></strong>
            </div>
            <?php echo form_open('horario/add',['class'=>'needs-validation'])?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="country" class="form-label">Professor(a):</label>
                    <select class="form-select" id="country" name="nIdAlocacao">
                        <option value="">Selecione ...</option>
                        <?php              
                
                foreach($professores as $professor):?>
                        <option value="<?=$professor['id']?>"><?=describeTeacher($professor['nome'],$professor['descricao'])?></option>
                <?php endforeach?>
                    </select>

                    <div class="">
                        <span style="color:red"
                            class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nIdAlocacao'):'';?></span>

                    </div>
                </div>
                <div class="col-sm-6">
                    <label for="firstName" class="form-label">Dia Semana:</label>
                    <input type="text" class="form-control" id="firstName" placeholder=""
                        value="<?=diaSemanaExtenso($diaSemana);?>" disabled="true">
                    <input type="hidden" name="ndiaSemana" class="form-control" id="firstName" placeholder=""
                        value="<?=$diaSemana;?>">
                </div>
                <div class="col-sm-6">
                    <label for="lastName" class="form-label">Posição da Aula:</label>
                    <input type="text" class="form-control" id="lastName" placeholder="" value="<?=$posicao.'º'?>"
                        disabled="true">
                    <input type="hidden" class="form-control" name="nPosicao" placeholder="" value="<?=$posicao?>">

                </div>
                <div class="col-md-6">
                    <label for="zip" class="form-label">Série:</label>
                    <input type="text" class="form-control"
                        value="<?=$idSerie['descricao']. ' '.$idSerie['classificacao']. ' - '.turno($idSerie['turno'])?>"
                        id="zip" placeholder="" disabled="true">
                    <input type="hidden" name="nSerie" class="form-control" value="<?=$idSerie['id']?>">
                </div>
            </div>
            <hr class="my-4">
            <button class="w-100 btn btn-primary btn-lg" type="submit">Salvar para continuar</button>
            </form>
        </div>
    </div>
</main>
<?= $this->endSection();?>