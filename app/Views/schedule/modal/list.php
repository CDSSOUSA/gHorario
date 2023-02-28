<div class="modal fade" id="listScheduleSeriesModal" tabindex="-1" aria-labelledby="listScheduleSeriesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title text-white font-weight-bold pl-3" id="listScheduleSeriesModalLabel"><i class="fa fa-th"></i> Quadro de Horário :: Série <label id="descriptionSerieFake" class="col-form-label"></label>    </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-6">
                        <!-- <label for="inputEmail3" class="col-form-label">Série :: </label> -->
                                             
                    </div>
                </div>
                <div class="card-body table-responsive p-0" >
                <!-- <label for="exampleColorInput" class="form-label">Dias/Aulas :: </label> -->
                   
                    <table id="tb_series_schedule"class="table" style="width: 100%";>
                        <thead>
                            <thead>
                                <tr>
                                    <th class="align-middle text-center"> <label for="exampleColorInput" class="form-label">Dias/Aulas :: </label></th>
                                    <?php                                      
                                    for ($dw = 2; $dw < 7; $dw++) { ?>
                                        <th style="border:1px solid #eaeaea" class="text-center align-middle"><?= diaSemanaExtenso($dw); ?></th>
                                    <?php } ?>
                                </tr>

                            </thead>
                        </thead>
                        <tbody>                       
                        </tbody>
                    </table>
                   
                </div>

            </div>
            <div class="modal-footer card-footer clearfix">
                <div class="float-right">
                    <?= generateButtonCloseModal(); ?>
                    <a id="btn_print"  class="btn btn-outline-dark" title="Imprimir" target="_blank"> 
                        <i class="fa fa-print"></i> Imprimir </a>
                </div>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>