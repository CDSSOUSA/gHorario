<?php

use App\Models\DisciplineModel;

echo $this->extend('layouts2/default');
echo $this->section('content');
?>

<div id="load">
    <div id="loader">
    </div>
</div>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-0 align-right">
            <div class="col-sm-12">
                <ul class="navbar-nav float-sm-right">
                    <div class="d-flex">
                        <li class="nav-item align-items-center m-1">
                            <?php echo anchor('#', '<i class="fa fa-cogs"></i> Consistência', ['onclick' => 'addTeacher()', 'data-toggle' => 'modal', 'class' => 'btn btn-outline-dark', 'title' => 'Consistência']); ?>
                        </li>

                        <li class="nav-item align-items-center m-1">
                            <?php echo anchor('#', '<i class="fa fa-print"></i> Imprimir', ['onclick' => 'addTeacher()', 'data-toggle' => 'modal', 'class' => 'btn btn-outline-dark', 'title' => 'Imprimir']); ?>

                        </li>

                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="d-flex bg-gradient-indigo shadow-primary b-radius-5 pt-4 pb-3">
                            <h5 class="text-white font-weight-bold pl-3"><?= $title; ?></h5>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <!-- <div class="card-body table-responsive p-0" style="height: auto;">
                        <table id="tb_schedule" class="table stripeeeee row-border order-column table-striped " style="width:100%"> -->

                        <div class="table-responsive p-0" style="height: auto;">
                            <table id="tb_schedule" class="table align-items-center mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th scope="row" class="align-middle">Dias</th>
                                        <th scope="row" class="align-middle text-center">Aulas</th>
                                        <?php

                                        foreach ($series as $serie) : ?>
                                            <th class="text-center">
                                                <?php echo anchor('#', $serie->description . 'º ' . $serie->classification, ['onclick' => 'listScheduleSeries(' . $serie->id . ')', 'data-toggle' => 'modal', 'class' => '', 'title' => 'Nova disciplina']); ?>
                                            </th>
                                        <?php endforeach; ?>
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

<?= view('/schedule/modal/list'); ?>
<?= view('/schedule/modal/add'); ?>
<?= view('/schedule/modal/delete'); ?>

<?= $this->endSection(); ?>