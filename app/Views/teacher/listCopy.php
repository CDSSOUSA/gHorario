<?php

use App\Models\ProfessorDisciplinaModel;
use App\Models\TeacDiscModel;

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
            <div class="col-12">
                <span id="msgAlertSuccess"></span>
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><?= $title ?></h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <?php
                                echo anchor('#', '<i class="icons fas fa-plus"></i> Novo professor', ['onclick' => 'addTeacher()', 'data-toggle' => 'modal', 'class' => 'btn btn-secondary']); ?>

                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: 50vh;">
                        <table id="tb_teacher" class="table table-head-fixed text-nowrap table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-left">Nome completo :: </th>
                                    <th class="text-left">Disciplina(s) / Qtde aula(s) :: </th>
                                    <!-- <th>Qtde total aulas :: </th> -->
                                    <th class="text-left">Ações :: </th>
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

<?php 
echo view('teacher/modal/add');
echo view('teacher/modal/delete');
echo view('teacDisc/modal/add');
echo view('teacDisc/modal/edit');
echo view('teacDisc/modal/delete');
echo view('allocation/modal/add');
echo view('allocation/modal/list');
echo view('allocation/modal/delete');

echo $this->endSection(); 
?>