var divLoad = document.querySelector('#load');
var divLoader = document.querySelector('#loader');
var titleSuccess = '<strong class="me-auto">Parabéns!</strong>';
var bodySuccess = ' Operação realizada com sucesso';
var success = 'success';

listTeacDisc();

async function listTeacDisc() {
    await axios.get(`${URL_BASE}/teacher/list`)
        .then(response => {
            const data = response.data;
            console.log(data);
            document.querySelector("#tb_teacher > tbody").innerHTML = `${loadDataTeacher(data)}`;
            //loadDataTable(data)
        }
        )
        .catch(error => console.log(error))
}



function loadDataTeacher(data) {
    let row = "";

    data.forEach((element, indice) => {
        //console.log(data)

        let ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="addTeacherDiscipline(${element.id})">
        <i class="fa fa-plus" aria-hidden="true"></i> Disciplina</a>
        <a href="#" class="btn btn-dark btn-sm" onclick="addAllocationTeacher(${element.id})">
        <i class="fa fa-plus" aria-hidden="true"></i> Alocação</a>`;

        // if (element.status === "A") {
        //     console.log(element.status)
        //     ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="activeSeries(${element.id})"><i class="fa fa-check-circle"></i> Desativar</a>`;
        // }
        row +=
            `<tr>
                <td class="align-middle">${indice + 1}</td>
                <td class="align-middle">${element.name}</td>   
                <td class="discipline">${document.getElementsByClassName("discipline").innerHTML = listRowDisciplinesTeacher(element.disciplines)}</td>                     
                <td class="align-middle">${ticket}</td>        
            </tr>`;

    });
    return row;
}

function listRowDisciplinesTeacher (data) {
    let row = '';    
    if(data != null){
        data.forEach( e => {            
            row += `<div class="d-flex justify-content-center">
                        <div class="m-2 p-2 font-weight-bold w-35" style="background-color:${e.color}; color:white">
                            <i class="icons fas fa-book"></i> ${e.abbreviation} :: ${e.amount}  
                        </div>
                        <div class="m-2 p-2 font-weight-bold w-25">
                            <a href="#" class="btn btn-dark" onclick="editTeacherDiscipline(${e.id})">
                            <i class="icons fas fa-pen"></i> Editar</a>          
                        </div>
                    </div>` ;
        })
    }
    return row;
}

const addTeacherModal = new bootstrap.Modal(document.getElementById('addTeacherModal'));
const addTeacherForm = document.getElementById('addTeacherForm');
async function addTeacher() {

    addTeacherModal.show();
    document.getElementById('msgAlertError').innerHTML = ''
    document.getElementById('fieldlertErrorname').innerHTML = ''
    document.getElementById('fieldlertErroramount').innerHTML = ''
    document.getElementById('fieldlertErrordisciplines').innerHTML = ''
    document.getElementById('fieldlertErrorcolor').innerHTML = ''

    addTeacherForm.reset();

    $('#addTeacherModal').on('shown.bs.modal', function () {
        $('#name').trigger('focus');
    });

}
console.log(addTeacherForm);
if (addTeacherForm) {
    addTeacherForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        //load();
        const dataForm = new FormData(addTeacherForm);
        await axios.post(`${URL_BASE}/teacher/create`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                console.log(response.data)
                if (response.data.error) {
                    console.log(response.data)
                    document.getElementById('msgAlertError').innerHTML = response.data.msg
                    const er = response.data.msgs;
                    console.log(er)
                    // er.forEach( (e,indice) => {

                    //     validateErros(e, 'fieldlertError' + indice);
                    // })
                    validateErros(response.data.msgs.name, 'fieldlertErrorname')
                    validateErros(response.data.msgs.amount, 'fieldlertErroramount')
                    validateErros(response.data.msgs.disciplines, 'fieldlertErrordisciplines')
                    validateErros(response.data.msgs.color, 'fieldlertErrorcolor')
                    //if(response.data.msgs.description){
                    //     document.getElementById('fieldlertErrorDescription').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`
                    // } else {
                    //     document.getElementById('fieldlertErrorDescription').innerHTML ='';
                    // }

                } else {
                    // load();
                    // //console.log(response.data)
                    // location.reload();
                    addTeacherModal.hide();
                    addTeacherForm.reset();
                    loadToast(titleSuccess, bodySuccess, success);
                    //loadDataTable(response.data)
                    //loada();
                    //listSeries();
                    //location.reload();
                    listTeacDisc();

                }
            })
            .catch(error => console.log(error))
    });
}

const editModal = new bootstrap.Modal(document.getElementById('editTeacherDisciplineModal'));

async function editTeacherDiscipline(id) {
    document.getElementById('msgAlertError').innerHTML = '';
    document.getElementById('fieldlertError').textContent = '';

    await axios.get(URL_BASE + '/teacDisc/edit/' + id)
        .then(response => {
            const data = response.data;
            console.log(data);
            if (data) {
                editModal.show();
                document.getElementById('idEdit').value = data[0].id
                document.getElementById('nameEdit').value = data[0].name
                document.getElementById('id_discipline').value = data[0].description
                document.getElementById('numeroAulas').value = data[0].amount
                document.getElementById('corDestaque').value = data[0].color
            }
        })
        .catch(error => console.log(error))
}

const editForm = document.getElementById('editTeacherDiscipline');
console.log(editForm);

if (editForm) {

    editForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const dataForm = new FormData(editForm);
        await axios.post(`${URL_BASE}/teacDisc/update`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                console.log(response.data.id_teacher);
                if (response.data.error) {
                    document.getElementById('msgAlertError').innerHTML = response.data.msg
                    document.getElementById('fieldlertError').textContent = 'Preenchimento obrigatório!'
                    document.getElementById("msgAlertSuccess").innerHTML = "";
                } else {

                    document.getElementById('msgAlertError').innerHTML = '';
                    document.getElementById('fieldlertError').textContent = '';
                    //document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                    //location.reload();
                    editModal.hide();
                    
                    loadToast(titleSuccess, bodySuccess, success);                        
                    //loada(); 
                    //location.reload();
                    listTeacDisc();

                }
            })
            .catch(error => console.log(error))
    })
}

// const listDisciplines = () =>{
   
//     let discipline = '';
//     const data = [
//         "HISTORIA",
//         "GEOGRAFA",
//         "MATEMATICA",
//         "ARTES",
//         "INGLES"
//     ]
//     data.forEach((e,i) => {
//         discipline += `<div class="abc form-check">
//         <input class="form-check-input" name="nDisciplines[]" value="${i}" type="checkbox" id="flexSwitchChec${i}">
//         <label class="form-check-label" for="flexSwitchChec${i}"> ${e} </label>
//         </div>` 
//     })
//     return discipline;
// }

const addModal = new bootstrap.Modal(document.getElementById('addTeacherDisciplineModal'));
async function addTeacherDiscipline(id) {
    document.getElementById('msgAlertErrorTeacDisc').innerHTML = '';
    document.getElementById('fieldlertErroramountTechDisc').innerHTML = ''
    document.getElementById('fieldlertErrordisciplinesTechDisc').innerHTML = ''
    document.getElementById('fieldlertErrorcolorTechDisc').innerHTML = ''
    
   
    //document.getElementById('fieldlertError').textContent = '';
    
   
    addForm.reset();
    addModal.show();
    document.getElementById('idTeac').value = id
    // document.getElementById('disciplines').innerHTML = listDisciplines()
    // document.querySelector('.abc').classList.add("form-switch");
    // console.log(addForm);

}

const addForm = document.getElementById('addTeacherDisciplineForm');
if (addForm) {
    addForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        // adicionar o toast
        /*$('#toast-place').append(`
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="toast-header">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close">
              <span aria-hidden">&time</span>;
              </button>
              </div>
              <div class="toast-body">
              Hello, world! This is a toast message.
            </div>
          </div>
          `);*/

        //$('.toast').toast('show');


        
        const dataForm = new FormData(addForm);
        await axios.post(`${URL_BASE}/teacDisc/create`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            console.log(response.data.id_teacher);
            if (response.data.error) {
                    console.log(response.data)
                    document.getElementById('msgAlertErrorTeacDisc').innerHTML = response.data.msg
                    //document.getElementById("msgAlertSuccess").innerHTML = "";
                    //document.getElementById('idTeac').value = id
                    //document.getElementById('msgAlertError').innerHTML = response.data.msg
                    //loadToast('oi','oila','danger');

                    //validateErros(response.data.msgs.name, 'fieldlertErrorname')
                    validateErros(response.data.msgs.amount, 'fieldlertErroramountTechDisc')
                    validateErros(response.data.msgs.disciplinesTeacher, 'fieldlertErrordisciplinesTechDisc')
                    validateErros(response.data.msgs.color, 'fieldlertErrorcolorTechDisc')

                    //addForm.reset()
                    

                } else {
                    document.getElementById('msgAlertError').innerHTML = '';
                    addModal.hide();
                    //document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                    
                    loadToast(titleSuccess, bodySuccess, success);                        
                    //loada(); 
                    //location.reload();
                    listTeacDisc();


                }
            })
            .catch(error => console.log(error))
    })
}
