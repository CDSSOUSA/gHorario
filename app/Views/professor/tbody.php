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