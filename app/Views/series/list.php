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
                        <h3 class="card-title font-weight-bold"><i class="fa fa-calendar-check"></i> Listar Séries :: </h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <?php
                                echo anchor('#', '<i class="icons fas fa-plus"></i> Novo', ['onclick' => 'addYearSchool()', 'data-toggle' => 'modal', 'class' => 'btn btn-secondary']); ?>
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

<?= $this->endSection(); ?>