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
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php
                    foreach ($breadcrumb as $item) {
                        echo $item;
                    } ?>

                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fa fa-users"></i> Listar séries :: </h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <?php
                                echo anchor('#', '<i class="icons fas fa-plus"></i> Nova Série', ['onclick' => 'addSeries()', 'data-toggle' => 'modal', 'class' => 'btn btn-secondary']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive p-0">
                            <table id="tb_series" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Descrição :: </th>
                                        <th scope="col">Status ::</th>
                                        <th scope="col">Ação :: </th>
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
            <div class="modal-header bg-dark font-weight-bold">
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

<?= $this->endSection(); ?>