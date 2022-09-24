var divLoad = document.querySelector('#load');
var divLoader = document.querySelector('#loader');

/*
** LISTAR DISCIPLINAS
**
*/

listDisciplines();

async function listDisciplines() {
    await axios.get(`${URL_BASE}/discipline/list`)
        .then(response => {
            const data = response.data;
            console.log(data);
            document.querySelector("#tb_discipline > tbody").innerHTML = `${loadDataDisciplines(data)}`;           
        }
        )
        .catch(error => console.log(error))
}

function loadDataDisciplines(data) {
    let ticket = '';
    let row = "";

    data.forEach((element, indice) => {      

        ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="editDiscipline(${element.id})"><i class="fa fa-pen" aria-hidden="true"></i> Editar</a> `;

        //Define botão de excluir
        if(!element.teacDisc){
            ticket += `<a href="#" class="btn btn-dark btn-sm" onclick="delDiscipline(${element.id})"><i class="fa fa-trash" aria-hidden="true"></i> Excluir</a>`
            } else {
                ticket += `<a href="#" class="btn btn-dark btn-sm disabled"><i class="fa fa-trash" aria-hidden="true"></i> Excluir</a>`
           
            }
       row +=
            `<tr class="text-sm text-secondary mb-0">
            
                <td class="align-middle">${indice + 1}</td>                
                <td>
                    <div class="d-flex px-2">
                        <div>
                            <img src="${URL_BASE}/assets/img/${element.icone}" width="35px"  class="avatar avatar-sm me-3 border-radius-lg m-2" alt="spotify">
                        </div>
                        <div class="my-auto">
                            <h6 class="mb-0 text-sm">${element.description}</h6>
                        </div>
                    </div>
                </td>
                <td class="align-middle">${element.abbreviation}</td>           
                <td class="align-middle text-center">${element.amount}</td>           
                <td class="align-middle">${ticket}</td>        
            </tr>`;

    });
    return row;
}

/*
** END
**
*/

/*
** ADICIONAR  DISCIPLINAS
**
*/


const addDisciplineModal = new bootstrap.Modal(document.getElementById('addDisciplineModal'));
const addDisciplineForm = document.getElementById('addDisciplineForm');

async function addDiscipline() {

    addDisciplineModal.show();
    document.getElementById('msgAlertErrorDiscipline').innerHTML = ''
    document.getElementById('fieldlertErrorDescriptionDiscipline').innerHTML = ''
    document.getElementById('fieldlertErrorAbbreviation').innerHTML = ''
    document.getElementById('fieldlertErrorAmount').innerHTML = ''
    addDisciplineForm.reset();
        $('#addDisciplineModal').on('shown.bs.modal', function () {
            $('#description').trigger('focus');
        });
    
 
}

if (addDisciplineForm) {
    addDisciplineForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        //load();
        const dataForm = new FormData(addDisciplineForm);
        await axios.post(`${URL_BASE}/discipline/create`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
                console.log(response.data)
                if (response.data.error) {
                    console.log(response.data)
                    document.getElementById('msgAlertErrorDiscipline').innerHTML = response.data.msg                                
                    validateErros(response.data.msgs.description, 'fieldlertErrorDescriptionDiscipline')
                    validateErros(response.data.msgs.abbreviation, 'fieldlertErrorAbbreviation')
                    validateErros(response.data.msgs.amount, 'fieldlertErrorAmount') 

                } else {
                    
                    addDisciplineModal.hide();
                    addDisciplineForm.reset();
                    loadToast(titleSuccess, bodySuccess, success);
                    
                    listDisciplines();

                }
            })
            .catch(error => console.log(error))
    })
}

/*
** END
**
*/

/*
** EDITAR  DISCIPLINAS
**
*/
//Cria o modal de edição
const editDisciplineModal = new bootstrap.Modal(document.getElementById('editDisciplineModal'));

//Função para editar disciplina
async function editDiscipline(id) {

    //Limpa os alert de erro do formulário
    document.getElementById('msgAlertErrorDiscipline').innerHTML = ''
    document.getElementById('fieldlertErrorDescriptionDisciplineEdit').innerHTML = ''
    document.getElementById('fieldlertErrorAbbreviationEdit').innerHTML = ''
    document.getElementById('fieldlertErrorAmountEdit').innerHTML = ''

    // Faz a chamada para buscar os dados pelo id
    await axios.get(URL_BASE + '/discipline/edit/' + id)
        .then(response => {
            const data = response.data;
            console.log(data);
            if (data) {
                //Chama o modal
                editDisciplineModal.show();
                //Define os dados no formulário
                document.getElementById('idDisciplineEdit').value = data.id
                document.getElementById('descriptionDisciplineEdit').value = data.description
                document.getElementById('abbreviationDisciplineEdit').value = data.abbreviation
                document.getElementById('amountDisciplineEdit').value = data.amount               
                
            }
        })
        .catch(error => console.log(error))
}
//Define os formulário de edição
const editDisciplineForm = document.getElementById('editDisciplineForm');

if (editDisciplineForm) {
    editDisciplineForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const dataForm = new FormData(editDisciplineForm);
        //Faz chamada para editar os dados
        await axios.post(`${URL_BASE}/discipline/update`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                
                if (response.data.error) {                   
                    //Exibe os erros no preechimento do formulário
                    document.getElementById('msgAlertErrorDiscipline').innerHTML = response.data.msg                                
                    validateErros(response.data.msgs.description, 'fieldlertErrorDescriptionDisciplineEdit')
                    validateErros(response.data.msgs.abbreviation, 'fieldlertErrorAbbreviationEdit')
                    validateErros(response.data.msgs.amount, 'fieldlertErrorAmountEdit') 
                } else {
                    //Remove o modal da tela
                    editDisciplineModal.hide();
                    //Carrega o alert toast
                    loadToast(titleSuccess, bodySuccess, success);
                    //Carrega a nova lista
                    listDisciplines();

                }
            })
            .catch(error => console.log(error))
    })
}

/*
** FIM
**
*/
/*
** EXCLUIR  DISCIPLINAS
**
*/
const delDisciplineModal = new bootstrap.Modal(document.getElementById('delDisciplineModal'));

async function delDiscipline(id) {
    await axios.get(URL_BASE + '/discipline/edit/' + id)
        .then(response => {
            const data = response.data;
            if (data) {
                console.log(data);
                delDisciplineModal.show();
                document.getElementById('idDisciplineDel').value = data.id
                document.getElementById('descriptionDisciplineDel').value = data.description              

            }
        })
        .catch(error => console.log(error))
    
}


const delDisciplineForm = document.getElementById('delDisciplineForm');

if (delDisciplineForm) {

    delDisciplineForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const dataForm = new FormData(delDisciplineForm);

        await axios.post(`${URL_BASE}/discipline/del`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                if (response.data.error) {
                    document.getElementById('msgAlertErrorDisciplineDelete').innerHTML = response.data.msg                  
                } else {

                    
                    delDisciplineModal.hide();                  
                    loadToast(titleSuccess, bodySuccess, success);  
                    listDisciplines();

                }
            })
            .catch(error => console.log(error))
    })
}

