
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title; ?></h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-secondary" aria-expanded="false">
                                    <i class="fa fa-cogs"></i> Consistência
                                </button>
                                &nbsp;&nbsp;
                                <button type="button" class="btn btn-sm btn-secondary" aria-expanded="false">
                                    <i class="fa fa-print"></i> Imprimir
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: auto;">
                        <table id="tb_schedule" class="table stripeeeee row-border order-column table-striped " style="width:100%">
                            <!-- <table class="table table-head-fixed text-nowrap table-striped"> -->
                            <thead class="table-primary">
                                <tr>
                                    <th scope="row" class="align-middle">Dias</th>
                                    <th scope="row" class="align-middle">Aulas</th>
                                    <?php
                                    $horario = $schoolSchedule;
                                    $discipline = new DisciplineModel();

                                    foreach ($series as $serie) : ?>
                                        <th class="text-center"><?= $serie->description . 'º ' . $serie->classification; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>                                
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
    </div>
</div>

<?=view('/schedule/modal/add');?>
<?=view('/schedule/modal/delete');?>

<?= $this->endSection(); ?>