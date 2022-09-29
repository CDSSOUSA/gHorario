<?php 
use App\Models\HorarioModel;
 echo $this->extend('layouts/default'); ?>
<?= $this->section('content');?>


<div class="col-md-12 p-lg-5 mx-auto my-5">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-d3 pb-2 mb-3 border-bottom">
        
        <h1 class="h2"><?=$title;?></h1>
        
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                This week
            </button>
        </div>
    </div>
    <div class=" border-left-<?=$msgs['alert']?> alert alert-show alert-<?=$msgs['alert']?>">
                    <strong><?=$msgs['message'];?></strong></div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Dias</th>
                    <th>Início</th>

                    <?php 
                    $horarioSegunda = new HorarioModel();            
            foreach ($series AS $serie): ?>
                    <th class="text-center"><?=$serie['descricao'].''.$serie['classificacao'];?></th>
                    <?php endforeach;?>
                </tr>

            </thead>
            <tbody>
                <?php               
                    
                 for($j = 2; $j < 7 ; $j++): 

                    if($j != 4){
                        for($i=1; $i < 7; $i++):  
                            echo '<tr>';
                            if($i == 1){
                                echo '<td>'.diaSemanaExtenso($j).'</td>';
                            } else{
                                echo '<td></td>';
                            }
                            
                            echo '<td>'.$i.'º </td>';                      
                            foreach ($series AS $serie):                       
                            $horarioSegundas = $horarioSegunda->getHorarioDiaSemana($j, $serie['id'], $i);
                        ?>
    
    
    
                    <td><?php 
                        if($j == 4){
                            echo 'HIGIENIZAÇÃO DA ESCOLA';
                        } 
                        else if(empty($horarioSegundas['nome']))
                        {  //echo $serie['id'];
                            echo anchor('horario/add_profissional_horario/'.$serie['id'].'/'.$j.'/'.$i, "DISPONÍVEL", array('type'=>'button', 'class'=>'btn btn-success'));
                        }
                        else{
                           echo $nome = '<span style="color:'.$horarioSegundas['cor_destaque'].';">'.$horarioSegundas["nome"].'</span>';
                            //echo anchor('add_profissinal_horario/'.$horarioSegundas['id'].'/'.$horarioSegundas[], $nome, array('type'=>'button', 'class'=>'btn btn-outline-dark'));
                        }?>
                    </td>
    
                    <?php 
                    endforeach;  
                    echo  '</tr>'; 
                endfor;
                echo '<tr><td colspan="12"></td></tr>';
                    } else{
                        echo '<tr style="color:blue; background: orange; font-size:16px" class="text-center">
                            <td>'.diaSemanaExtenso($j).'</td>
                            <td colspan="12">HIGIENIZAÇÃO DA ESCOLA</td>
                            </tr>';
                    }
                 
                     
                endfor;  
                ?>
            </tbody>

        </table>
    </div>
      </div>
<?= $this->endSection();?>