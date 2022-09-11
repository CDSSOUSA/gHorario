<?php

use App\Models\ProfessorDisciplinaModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>

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
            <div class="col-md-6">
                <?php if ($msgs['alert']) : ?>
                    <div class="alert alert-close alert-<?= $msgs['alert'] ?> bg-<?= $msgs['alert'] ?> text-light border-0 alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle"></i><?= $msgs['message']; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                endif;
                session()->remove('success');
                session()->remove('erro');
                session()->remove('error'); ?>
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><?= $title ?></h3>
                    </div>

                    <?php echo form_open('yearSchool/create') ?>
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-6">
                                <label for="lastName" class="form-label">Ano letivo ::</label>
                                <input type="number" min="<?= getenv('YEAR.START'); ?>" max="<?= getenv('YEAR.END'); ?>" name="description" class="form-control" id="lastName" placeholder="Ex: 2023" value="<?= set_value('description') ?>">
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
                           
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="table">
                    <table>
                        <thead>
                            <th>
                                <tr>Id</tr>
                            </th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>