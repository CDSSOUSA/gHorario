<?php

use App\Models\HorarioModel;

echo $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<h2>Cadastrar Horário</h2>
<div class=" border-left-<?= $msgs['alert'] ?> alert alert-show alert-<?= $msgs['alert'] ?>">
    <strong><?= $msgs['message']; ?></strong>
</div>
<div class="table-responsive">
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

                
                    for ($i = 1; $i < 7; $i++) :
                        echo '<tr>';
                        if ($i == 1) {
                            echo '<td>' . diaSemanaExtenso($j) . '</td>';
                        } else {
                            echo '<td></td>';
                        }

                        echo '<td>' . $i . 'ª </td>';
                        foreach ($series as $serie) :
                            $horarioSegundas = $horarioSegunda->getHorarioDiaSemana($j, $serie['id'], $i);                           
                            ?>
                            <td><?php
                                 if (empty($horarioSegundas['id_professor_alocacao'])) {  //echo $serie['id'];
                                    echo anchor('horario/add_profissional_horario/' . $serie['id'] . '/' . $j . '/' . $i, "DISPONÍVEL", array('type' => 'button', 'class' => 'btn btn-success'));
                                } else {

                                    echo anchor('horario/edit_profissional_horario/' . $serie['id'] . '/' . $j . '/' . $i, word_limiter($horarioSegundas["nome"],1,'').' - '.convertDiscipline($horarioSegundas['descricao']) , array('type' => 'button', 'class' => 'btn btn-link btn-sm','style' => 'color:' . $horarioSegundas['cor_destaque']));
                                    //echo $nome = '<p style="color:' . $horarioSegundas['cor_destaque'] . '; display:flex; justify-content:center; align-items:center; font-size:10px;">' . word_limiter($horarioSegundas["nome"],1,'').' - '.convertDiscipline($horarioSegundas['descricao']) . '</p>';
                                    //echo anchor('add_profissinal_horario/'.$horarioSegundas['id'].'/'.$horarioSegundas[], $nome, array('type'=>'button', 'class'=>'btn btn-outline-dark'));
                                } ?>
                            </td>

            <?php
                        endforeach;
                        echo  '</tr>';
                    endfor;
                    echo '<tr><td colspan="13"></td></tr>';
                


            endfor;
            ?>
        </tbody>

    </table>
</div>
<?= $this->endSection(); ?>