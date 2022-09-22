<?php $contador = 1;
foreach ($teachers as $data) : ?>
    <tr>
        <td class="align-middle"><?= $contador++; ?></td>
        <td class="align-middle"><?= $data->name; ?></td>
        <td width="20px">
            <?php
            $disciplines = new TeacDiscModel();
            $disciplinesTeacher = $disciplines->getTeacherDisciplineByIdTeacher($data->id);
            foreach ($disciplinesTeacher as $item) : ?>
                <div class="m-2 p-2 font-weight-bold" style="background-color:<?= $item->color; ?>; color:white">
                    <i class="icons fas fa-book"></i> <?= $item->abbreviation; ?> :: <?= $item->amount; ?>
                </div>
            <?php endforeach; ?>
        </td>
        <td class="align-middle text-center"><?= $data->amount; ?></td>

        <td class="align-middle">
            <!-- Button trigger modal -->

            <?= anchor('/teacDisc/list/' . $data->id, '<i class="icons fas fa-book"></i> Adicionar Disciplina', ['class' => 'btn btn-dark']); ?>
            <?php //anchor('#', '<i class="icons fas fa-pen"></i> Editar professor', ['data-bs-toggle' => 'modal', 'class' => 'btn btn-dark']); 
            ?>
            <?php
            if (count($disciplinesTeacher) >= 1) {
                echo anchor('alocacao/add/' . $data->id, '<i class="icons fas fa-calendar"></i> Adicionar Alocação', ['class' => 'btn btn-dark']);
            } ?>
        </td>
    </tr>
<?php endforeach; ?>



<?php
$myDiscipline = [];
foreach ($teacDisc as $a) {
    $myDiscipline[] = $a->id_discipline;
}
foreach ($disciplines->findAll() as $item) :
    if (!in_array($item->id, $myDiscipline)) : ?>
        <div class="form-check form-switch">
            <input class="form-check-input" name="nDisciplinas[]" value="<?= $item->id; ?>" <?php echo set_checkbox('nDisciplinas', $item->id); ?> type="checkbox" id="flexSwitchCheckDefault<?= $item->id; ?>">
            <label class="form-check-label" for="flexSwitchCheckDefault<?= $item->id; ?>"> <?= $item->description; ?> </label>
        </div>

<?php endif;

endforeach ?>
<span style="color:red" class="font-italic font-weight-bold"><?php echo $erro !== '' ? $erro->getError('nDisciplinas') : ''; ?></span>



<div class="form-check form-switch">
    <div class="bootstrap-switch-mini bootstrap-switch-id-flexSwitchCheckDefault1 bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate bootstrap-switch-off" style="width: 49.1876px;">
        <div class="bootstrap-switch-container" style="width: 70.7814px; margin-left: -23.5938px;">
        <span class="bootstrap-switch-handle-on bootstrap-switch-success" style="width: 23.6px;"><i class="fa fa-check"></i></span>
        <span class="bootstrap-switch-label" style="width: 23.6px;">&nbsp;</span>
        <span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 23.6px;"></span>
        <input class="form-check-input" name="disciplines[]" value="1" type="checkbox" id="flexSwitchCheckDefault1"></div>
    </div>
    <label class="form-check-label" for="flexSwitchCheckDefault1"> GEOGRAFIA </label>
</div>

<div class="form-check form-switch">
        <input class="form-check-input" name="nDisciplinas[]" value="0" type="checkbox" id="flexSwitchCheckDefault0">
        <label class="form-check-label" for="flexSwitchCheckDefault0"> HISTORIA </label>
        </div>