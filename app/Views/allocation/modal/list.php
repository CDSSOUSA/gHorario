<!-- modal list-->
<div class="modal fade" id="listAllocationModal" tabindex="-1" role="dialog" aria-labelledby="listAllocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title text-white font-weight-bold pl-3" id="listAllocationModalLabel">
                    <i class="fa fa-user"></i> Alocação(ões) Realizada(s) ::
                    Prof (a) :: <label id="nameDisciplineAllocation" class="col-form-label"></label>
                </h5>               
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-6">
                        <!-- <label for="inputEmail3" class="col-form-label" id="">Nome completo :: </label><br> -->
                        <!-- <input id="nameDisciplineAllocation" disabled class="form-control"> -->
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="inputEmail3" class="col-form-label" id="">Quantidade de aulas:: <span id="totalAulaAllocation"></span> de <span  id="totalWorkload"></span>
</label>
                        <input type="hidden" class="form-control" id="totalAllocation">
                        

                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <!-- <label for="exampleColorInput" class="form-label">Dias/Aulas :: </label> -->

                    <table id="tb_allocationa" class="table" style="width: 100%" ;>
                        <thead>
                            <thead>
                                <tr>
                                    <th class="align-middle text-center"><label for="exampleColorInput" class="form-label">Dias/Aulas :: </label></th>
                                    <?php

                                    use App\Models\AllocationModel;

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
                </div>
            </div>
        </div>
    </div>
</div>