<?= $this->extend('layouts/default-table'); ?>
<?= $this->section('table');?>
<table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">SEG</th>
                <th scope="col">TER</th>
                <th scope="col">QUA</th>
                <th scope="col">QUI</th>
                <th scope="col">SEX</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1,001</td>
                <td>random</td>
                <td>data</td>
                <td>placeholder</td>
                <td>text</td>
            </tr>
            <tr>
                <td>1,002</td>
                <td>placeholder</td>
                <td>irrelevant</td>
                <td>visual</td>
                <td>layout</td>
            </tr>
            <tr>
                <td>1,003</td>
                <td>data</td>
                <td>rich</td>
                <td>dashboard</td>
                <td>tabular</td>
            </tr>
            <tr>
                <td>1,003</td>
                <td>information</td>
                <td>placeholder</td>
                <td>illustrative</td>
                <td>data</td>
            </tr>
            <tr>
                <td>1,004</td>
                <td>text</td>
                <td>random</td>
                <td>layout</td>
                <td>dashboard</td>
            </tr>
            <tr>
                <td>1,005</td>
                <td>dashboard</td>
                <td>irrelevant</td>
                <td>text</td>
                <td>placeholder</td>
            </tr>
            <tr>
                <td>1,006</td>
                <td>dashboard</td>
                <td>illustrative</td>
                <td>rich</td>
                <td>data</td>
            </tr>
            <tr>
                <td>1,007</td>
                <td>placeholder</td>
                <td>tabular</td>
                <td>information</td>
                <td>irrelevant</td>
            </tr>
            <tr>
                <td>1,008</td>
                <td>random</td>
                <td>data</td>
                <td>placeholder</td>
                <td>text</td>
            </tr>
            <tr>
                <td>1,009</td>
                <td>placeholder</td>
                <td>irrelevant</td>
                <td>visual</td>
                <td>layout</td>
            </tr>
            <tr>
                <td>1,010</td>
                <td>data</td>
                <td>rich</td>
                <td>dashboard</td>
                <td>tabular</td>
            </tr>
            <tr>
                <td>1,011</td>
                <td>information</td>
                <td>placeholder</td>
                <td>illustrative</td>
                <td>data</td>
            </tr>
            <tr>
                <td>1,012</td>
                <td>text</td>
                <td>placeholder</td>
                <td>layout</td>
                <td>dashboard</td>
            </tr>
            <tr>
                <td>1,013</td>
                <td>dashboard</td>
                <td>irrelevant</td>
                <td>text</td>
                <td>visual</td>
            </tr>
            <tr>
                <td>1,014</td>
                <td>dashboard</td>
                <td>illustrative</td>
                <td>rich</td>
                <td>data</td>
            </tr>
            <tr>
                <td>1,015</td>
                <td>random</td>
                <td>tabular</td>
                <td>information</td>
                <td>text</td>
            </tr>
        </tbody>
    </table>
    <?= $this->endSection();?>

    <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">SEGUNDA</th>
                    <th scope="col">TERÇA</th>
                    <th scope="col">QUARTA</th>
                    <th scope="col">QUINTA</th>
                    <th scope="col">SEXTA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$horarioSegunda = new HorarioModel(); 
                         
                        // $horarioSegunda = new HorarioModel();
            for($i=1; $i < 7; $i++):?>
                <tr>
                <td><?=$i.'º';?></td>
                    <?php 
                    for($j = 2; $j < 7 ; $j++){
                                               
                        $horarioSegundas = $horarioSegunda->getHorarioDiaSemana($j,1,$i);
                       ?>

                 
                    <td><?php 
                    
                    if(empty($horarioSegundas['nome'])){
                       
                        echo anchor('add_profissinal_horario/', "DISPONÍVEL", array('type'=>'button', 'class'=>'btn btn-success'));
                    } else{
                        $nome = '<span style="color:'.$horarioSegundas['cor_destaque'].';">'.$horarioSegundas["nome"].'</span>';
                        echo anchor('add_profissinal_horario/'.$horarioSegundas['id'].'/'.$horarioSegundas[], $nome, array('type'=>'button', 'class'=>'btn btn-outline-dark'));
                    }?>
                    </td>                   
               
                <?php                    
                        
                    } ?>
                    
                </tr>

                <?php endfor;?>

            </tbody>

            <td><?=$j;?></td>
                    <td><?=$i;?>º</td>