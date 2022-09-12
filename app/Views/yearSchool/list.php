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
                        <h3 class="card-title font-weight-bold"><i class="fa fa-calendar-check"></i> Listar Ano Letivo :: </h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <?php
                                echo anchor('#', '<i class="icons fas fa-plus"></i> Novo', ['onclick' => 'addYearSchool()', 'data-toggle' => 'modal', 'class' => 'btn btn-secondary']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive p-0">
                            <table id="tb_year" class="table table-striped">
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
<!-- modal add -->
<div class="modal fade" id="addYearSchoolModal" tabindex="-1" role="dialog" aria-labelledby="addYearSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark font-weight-bold">
                <h5 class="modal-title" id="addTeacherDisciplineModal">Cadastrar Ano Letivo :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>

                <?php echo form_open('yearSchool/create', ['id' => 'addYearSchoolForm']);
                echo csrf_field()
                ?>

                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-6">
                            <span id="checkAll"></span>
                            <label for="description" class="form-label">Ano letivo ::</label>
                            <input data-autofocus type="number" min="<?= getenv('YEAR.START'); ?>" max="<?= getenv('YEAR.END'); ?>" name="description" class="form-control" id="description" placeholder="Ex: 2023" value="<?= set_value('description') ?>">
                            <span class="error invalid-feedback" id="fieldlertError"></span>
                            <?php if ($erro !== '')
                                echo generateAlertFieldErro($erro->getError('description'));

                            if (isset($error))
                                echo generateAlertFieldErro($error);
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="card-footer">
                        <?= generationButtonSave(); ?>
                        <?= generateButtonClear(); ?>
                        <?= generateButtonCloseModal(); ?>

                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="activateYearSchoolModal" tabindex="-1" role="dialog" aria-labelledby="activateYearSchoolLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark font-weight-bold">
                <h5 class="modal-title" id="activateYearSchoolModalLabel">Ativar Ano Letivo :: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-bs-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertError"></span>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong> <i class="fa fa-exclamation-triangle"></i> Atenção! </strong>Todos os dados dos outros anos serão desativados!
                    
                </div>
                <?php echo form_open('yearSchool/active', ['id' => 'activateYearSchoolForm']);
                echo csrf_field()
                ?>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <span id="checkAll"></span>
                            <label for="description" class="form-label">Ano letivo ::</label>
                            <input id="id" name="id" type="hidden"> 
                            <input id="descriptionFake" type="text" class="form-control" disabled> 
                        </div>
                    </div>
                    <hr>
                    <div class="card-footer">
                        <?= generationButtonSave(); ?>                       
                        <?= generateButtonCloseModal(); ?>

                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>