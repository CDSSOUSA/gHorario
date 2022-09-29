<?php

use App\Models\ProfessorDisciplinaModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>
<div id="load">
    <div id="loader">
    </div>
</div>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            
            <div class="col-sm-12">
            <ul class="navbar-nav float-sm-right">
                    <li class="nav-item d-flex"> 
                        <?php echo anchor('#', 'Cadastrar Série', ['onclick' => 'addSeries()', 'data-toggle' => 'modal', 'class' => 'btn btn-outline-dark', 'title' => 'Nova série']); ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="d-flex bg-gradient-indigo shadow-primary b-radius-5 pt-4 pb-3">
                            <h5 class="text-white font-weight-bold pl-3">Listar Séries :: </h5>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tb_series" class="table align-items-center mb-0 table-striped">
                                <thead>                                    
                                    <tr>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7">#</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Descrição :: </th>
                                        <th class="text-left text-uppercase text-xxs font-weight-bolder opacity-7">Status :: </th>
                                        <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantidade :: </th> -->
                                        <!-- <th>Qtde total aulas :: </th> -->
                                        <th class="text-center"></th>
                                    </tr>                                    
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
    </div>
</div>
<!-- modal active -->

<div class="modal fade" id="addSeriesModal" tabindex="-1" role="dialog" aria-labelledby="addSeriesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title" id="addSeriesModalLabel"><i class="fa fa-users"></i> Cadastrar Série :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>
                <?php echo form_open('series/create', ['id' => 'addSeriesForm']);
                echo csrf_field()
                ?>

                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-6">
                            <label for="description" class="form-label">Descrição :: </label>
                            <input type="text" name="description" class="form-control" id="description" placeholder=" Ex.: 6, 7, 8 ..." value="<?= set_value('description') ?>">
                            <span class="error invalid-feedback" id="fieldlertErrordescription"></span>
                            <span class="error invalid-feedback" id="fieldlertDuplicative"></span>

                        </div>
                        <div class="form-group col-6">
                            <label for="description" class="form-label">Turma :: </label>
                            <input type="text" name="classification" class="form-control" id="firstName" placeholder="Ex.: A,B,C ... " value="<?= set_value('classification') ?>">
                            <span class="error invalid-feedback" id="fieldlertErrorclassification"></span>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="description" class="form-label">Turno :: </label>
                            <select class="form-control" name="shift">
                                <option value="">Selecione . . . </option>
                                <option value="M">MANHÃ</option>
                                <option value="T">TARDE</option>
                            </select>
                           <span class="error invalid-feedback" id="fieldlertErrorshift"></span>
                        </div>

                        <div class="form-group col-6">
                            <label for="idYearSchool" class="form-label">Ano Letivo :: </label>
                            <input type="text" class="form-control" value="<?= session('session_DescriptionYearSchool'); ?>" disabled>
                            <input type="hidden" name="id_year_school" class="form-control" value="<?= session('session_idYearSchool'); ?>">
                            <input type="hidden" name="status" value="A">
                            <?php if ($erro !== '')
                                echo generateAlertFieldErro($erro->getError('yearSchool')); ?>
                        </div>

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
<div class="modal fade" id="activeSeriesModal" tabindex="-1" role="dialog" aria-labelledby="activeSeriesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark font-weight-bold">
                <h5 class="modal-title" id="activeSeriesModalLabel"><i class="fa fa-users"></i> Ativar/Desativar Série :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>
                <?php echo form_open('series/active', ['id' => 'activeSerieForm']);
                echo csrf_field()
                ?>

                <div class="card-body">
                <div class="row">
                        <div class="form-group col-6">
                            <span id="checkAll"></span>
                            <label for="description" class="form-label">Série ::</label>
                            <input id="id" name="id" type="text">
                            <input id="status" name="status" type="text">
                            <input id="descriptionFake" type="text" class="form-control" disabled>
                        </div>
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
<?=view('series/modal/edit');?>

<?= $this->endSection(); ?>