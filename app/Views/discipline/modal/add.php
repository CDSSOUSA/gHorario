<!-- Modal addTeacher -->
<div class="modal fade" id="addDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="addDisciplineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-default-discipline">
                <h5 class="modal-title" id="addDisciplineModalLabel"><i class="fa fa-book"></i> Adicionar Disciplina ::</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="msgAlertErrorDiscipline"></span>
                <?php echo form_open('discipline/create', ['id' => 'addDisciplineForm']);
           
                echo csrf_field()
                ?>
                <span id="checkAll"></span>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="description" class="form-label">Descrição :: </label>
                        <input class="form-control" id="description" name="description">
                        <span class="error invalid-feedback" id="fieldlertErrorDescriptionDiscipline"></span>
                    </div>
                    <div class="form-group col-6">
                        <label for="abbreviation" class="form-label">Abreviação :: </label>
                        <input class="form-control" id="abbreviation" name="abbreviation">
                        <span class="error invalid-feedback" id="fieldlertErrorAbbreviation"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="amount" class="form-label">Quantidade de aulas :: </label>
                        <input type ="number" min="1" max="10" class="form-control" id="amount" name="amount">
                        <span class="error invalid-feedback" id="fieldlertErrorAmount"></span>
                    </div>     
                                
                    <div class="form-group col-6">
                        <label for="amount" class="form-label">Ícone :: </label>                       

                       <select id="id_select2_examplee" class="form-control" name="icone">
                        <option value="">Selecione ...</option>
                        <option value="icon-artes.png">Artes</option>
                        <option value="icon-biologia.png">Biologia</option>
                        <option value="icon-ciencias.png">Ciências</option>
                        <option value="icon-edfisica.png">Ed Física</option>
                        <option value="icon-filosofia.png">Filosofia</option>
                        <option value="icon-fisica.png">Física</option>
                        <option value="icon-geografia.png">Geografia</option>
                        <option value="icon-gramatica.png">Gramática</option>
                        <option value="icon-historia.png">História</option>
                        <option value="icon-ingles.png">Inglês</option>
                        <option value="icon-matematica.png">Matemática</option>
                        <option value="icon-musica.png">Música</option>
                        <option value="icon-portugues.png">Português</option>
                        <option value="icon-quimica.png">Química</option>
                        <option value="icon-redacao.png">Redação</option>
                        <option value="icon-religiao.png">Religião</option>
                        <option value="icon-sociologia.png">Sociologia</option>
                        <option value="icon-teatro.png">Teatro</option>
                        </select>
                       
                        <span class="error invalid-feedback" id="fieldlertErrorIcone"></span>
                    </div>                    
                </div>
                
               
            </div>
            <div class="modal-footer card-footer">
                <?= generationButtonSave(); ?>
                <?= generateButtonCloseModal(); ?>

            </div>
            </form>

        </div>
    </div>
</div>