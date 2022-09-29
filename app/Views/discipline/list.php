<?php

use App\Models\ProfessorDisciplinaModel;
use App\Models\TeacDiscModel;

echo $this->extend('layouts2/default');
echo $this->section('content'); ?>
<div class="content-header">
    <div class="container">
        <div class="row mb-0 align-right">
            <div class="col-sm-12">
                <ul class="navbar-nav float-sm-right">
                    <li class="nav-item d-flex"> 
                        <?php echo anchor('#', 'Cadastrar Disciplina', ['onclick' => 'addDiscipline()', 'data-toggle' => 'modal', 'class' => 'btn btn-outline-dark', 'title' => 'Nova disciplina']); ?>
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
                            <h5 class="text-white font-weight-bold pl-3">Listar Disciplinas :: </h5>

                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tb_discipline" class="table align-items-center mb-0 table-striped">
                                <thead>                                    
                                    <tr>
                                        <th class="text-uppercase  text-xxs font-weight-bolder opacity-7">#</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder opacity-7">Descrição :: </th>
                                        <th class="text-left text-uppercase text-xxs font-weight-bolder opacity-7">Abreviação :: </th>
                                        <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">Quantidade :: </th>
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