<!-- modal list-->
<div class="modal fade" id="listAllocationModal" tabindex="-1" role="dialog" aria-labelledby="listAllocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title" id="listAllocationModalLabel"><i class="fa fa-user"></i> Alocação(ões) Realizada(s) ::</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="inputEmail3" class="col-form-label" id="">Nome completo :: </label><br>
                        <input id="nameDisciplineAllocation" disabled class="form-control">
                    </div>
                </div>
                <div class="card-body table-responsive p-0" style="height: 50vh;">
                    <table id="tb_allocation" class="table table-head-fixed text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <!-- <th scope="col">Dia :: </th> -->
                                <th scope="col">Disciplina :: </th>
                                <!-- <th scope="col">Posição ::</th> -->
                                <th scope="col">Situação ::</th>
                                <!-- <th scope="col">Turno ::</th> -->
                                <th scope="col">Ações :: </th>
                            </tr>
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