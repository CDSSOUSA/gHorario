<?php

use App\Models\ProfessorDisciplinaModel;
use App\Models\TeacDiscModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> <small><?= $title ?></small></h1>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <?php
                        echo anchor('#', '<i class="icons fas fa-plus"></i> Nova disciplina', ['onclick' => 'addDiscipline()', 'data-toggle' => 'modal', 'class' => 'btn btn-secondary']); ?>

                    </div>

                    <div class="card-body">
                        <table id="tb_discipline" class="table table-bordered">
                            <thead>
                                <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <th>#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descrição :: </th>
                                    <th class="text-left">Abreviação :: </th>
                                    <th class="text-center">Quantidade :: </th>
                                    <!-- <th>Qtde total aulas :: </th> -->
                                    <th class="text-left">Ações :: </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <!-- <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">«</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">»</a></li>
                    </ul>
                </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo view('discipline/modal/add');
echo view('discipline/modal/edit');
echo view('discipline/modal/delete');
// echo view('teacher/modal/delete');
// echo view('teacDisc/modal/add');
// echo view('teacDisc/modal/edit');
// echo view('teacDisc/modal/delete');
// echo view('allocation/modal/add');
// echo view('allocation/modal/list');
// echo view('allocation/modal/delete');

echo $this->endSection();
?>