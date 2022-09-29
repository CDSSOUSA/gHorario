<?php
echo $this->extend('layouts/main');
echo $this->section('content'); ?>
<section class="section">
    <div class="row">
        <div class="col-lg-2">
            <div class="card">
                <div class="drag__container">
                    <?php foreach ($teacherDiscipline as $item) :
                        for ($i = 1; $i <= $item->amount; $i++) : ?>
                            <div style="background-color:<?= $item->color ?>" class="ticket" draggable="true">
                                <span class="abbreviation"><?= $item->abbreviation; ?></span>
                                <p class="text-white drag"><?= abbreviationTeacher($item->name); ?></p>
                            </div>
                    <?php endfor;
                    endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="card">
                <div class="drop__container">
                <?php
                for ($i = 1; $i <= 10; $i++) : ?>
                    <div class="drop__item">                     
                    </div>
                <?php endfor;
                ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection(); ?>