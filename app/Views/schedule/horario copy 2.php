<?php

use App\Models\HorarioModel;

echo $this->extend('layouts/main');
echo $this->section('content');
?>

<div class="col-lg-12">
    <div class="cadrd">
        <div class="card-body">
        <?php if($msgs['alert']):?>
            <div class="alert alert-<?=$msgs['alert']?> bg-<?=$msgs['alert']?> text-light border-0 alert-dismissible fade show" role="alert">
            <?=$msgs['message'];?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php endif;?>
            <!-- Default Table -->
            <table class="table table-sm">
                <thead>

                    <tr>
                        <th>Dias</th>
                        <th>Aulas</th>
                        <?php
                        $horarioSegunda = new HorarioModel();
                        foreach ($series as $serie) : ?>
                            <th class="text-center"><?= $serie['descricao'] . 'º ' . $serie['classificacao']; ?></th>
                        <?php endforeach; ?>
                    </tr>

                </thead>
                <tbody>

                    <?php
                    for ($j = 2; $j < 7; $j++) :
                        for ($i = 1; $i < 7; $i++) : ?>
                            <tr>
                                <th scope="row">
                                    <?php if ($i == 1) : ?>
                                        <?= diaSemanaExtenso($j); ?>
                                    <?php endif; ?>
                                </th>
                                <th><?= $i . 'º'; ?></th>
                                <?php foreach ($series as $serie) :
                                    $horarioSegundas = $horarioSegunda->getHorarioDiaSemana($j, $serie['id'], $i);
                                ?>
                                    <td><?php
                                        if (empty($horarioSegundas['id_professor_alocacao'])) {  //echo $serie['id'];
                                            echo anchor('horario/add_profissional_horario/' . $serie['id'] . '/' . $j . '/' . $i, "DISPONÍVEL", array('type' => 'button', 'class' => 'btn btn-success btn-sm'));
                                        } else {
                                            echo anchor('horario/edit_profissional_horario/' . $serie['id'] . '/' . $j . '/' . $i, word_limiter($horarioSegundas["nome"], 1, '') . ' - ' . convertDiscipline($horarioSegundas['descricao']), array('type' => 'button', 'class' => 'btn btn-link btn-sm text-white', 'style' => 'background-color:' . $horarioSegundas['cor_destaque']));
                                            //echo $nome = '<p style="color:' . $horarioSegundas['cor_destaque'] . '; display:flex; justify-content:center; align-items:center; font-size:10px;">' . word_limiter($horarioSegundas["nome"],1,'').' - '.convertDiscipline($horarioSegundas['descricao']) . '</p>';
                                            //echo anchor('add_profissinal_horario/'.$horarioSegundas['id'].'/'.$horarioSegundas[], $nome, array('type'=>'button', 'class'=>'btn btn-outline-dark'));
                                        } ?>
                                    </td>

                                <?php endforeach; ?>
                            </tr>
                    <?php endfor;
                    endfor; ?>
                </tbody>
            </table>
            <!-- End Default Table Example -->
        </div>
    </div>

</div>

<?= $this->endSection(); ?>