var divLoad = document.querySelector('#load');
var divLoader = document.querySelector('#loader');
var titleSuccess = '<strong class="me-auto">Parabéns!</strong>';
var bodySuccess = ' Operação realizada com sucesso';
var success = 'success';
//var idTeacheDiscipline = 11;

// const btnListAllocation = `<a href="#" class="btn btn-dark btn-sm" onclick="listAllocationTeacherDiscipline(${idTeacheDiscipline})">
// <i class="fa fa-list" aria-hidden="true"></i> Alocação</a>`


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
    let rowAllocation = '';

    data.forEach((element, indice) => {
        //console.log(data)

        if(element.disciplines){            
            rowAllocation = `<a href="#" class="btn btn-dark btn-sm" onclick="addAllocationTeacher(${element.id})">
                                <i class="fa fa-plus" aria-hidden="true"></i> Alocação</a>
                            <a href="#" class="btn btn-dark btn-sm" onclick="listAllocationTeacherDiscipline(${element.id})">
                                <i class="fa fa-list" aria-hidden="true"></i> Alocação</a>`
        } else {
            rowAllocation = '';

        }

        let ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="addTeacherDiscipline(${element.id})">
        <i class="fa fa-plus" aria-hidden="true"></i> Disciplina</a>
        ${rowAllocation}
        
        `;

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
const addFormTeacDisc = document.getElementById('addTeacherDisciplineForm');
async function addTeacherDiscipline(id) {
    document.getElementById('msgAlertErrorTeacDisc').innerHTML = '';
    document.getElementById('fieldlertErroramountTechDisc').innerHTML = ''
    document.getElementById('fieldlertErrordisciplinesTechDisc').innerHTML = ''
    document.getElementById('fieldlertErrorcolorTechDisc').innerHTML = ''
    
   
    //document.getElementById('fieldlertError').textContent = '';
    
   
    addFormTeacDisc.reset();
    addModal.show();
    document.getElementById('idTeac').value = id
    getDataTeacher(id,'nameDiscipline');
    getDataTeacherDiscipline(id)
    
    // document.getElementById('disciplines').innerHTML = listDisciplines()
    // document.querySelector('.abc').classList.add("form-switch");
    // console.log(addForm);
    $('#addTeacherDisciplineModal').on('shown.bs.modal', function () {
        $('#amount').trigger('focus');
    });


}

if (addFormTeacDisc) {
    addFormTeacDisc.addEventListener("submit", async (e) => {
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


        
        const dataForm = new FormData(addFormTeacDisc);
        await axios.post(`${URL_BASE}/teacDisc/create`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            console.log(response.data.id_teacher);
            if (response.data.error) {
                    console.log(response.data.msg)
                    document.getElementById('msgAlertErrorTeacDisc').innerHTML = response.data.msg
                    //document.getElementById("msgAlertSuccess").innerHTML = "";
                    //document.getElementById('idTeac').value = id
                    //document.getElementById('msgAlertError').innerHTML = response.data.msg
                    //loadToast('oi','oila','danger');

                    //validateErros(response.data.msgs.name, 'fieldlertErrorname')
                    // if(response.data.error.code == 1062){
                    //     validateErros(response.data.msgs.disciplinesTeacher, 'fieldlertErrordisciplinesTechDisc')
                    // }
                    validateErros(response.data.msgs.amount, 'fieldlertErroramountTechDisc')
                    validateErros(response.data.msgs.disciplinesTeacher, 'fieldlertErrordisciplinesTechDisc')
                    validateErros(response.data.msgs.color, 'fieldlertErrorcolorTechDisc')

                    //addForm.reset()
                    

                } else {
                    document.getElementById('msgAlertError').innerHTML = '';
                    addFormTeacDisc.reset();
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

const addAllocationModal = new bootstrap.Modal(document.getElementById('addAllocationModal'));
const addAllocationForm = document.getElementById('addAllocationForm');

async function getDataTeacher(id,locale) {

    await axios.get(`${URL_BASE}/teacher/show/${id}`)
        .then(response => {
            const data = response.data;

            console.log(data);
            if (data) {
                //editModal.show();
                //document.getElementById('idEdit').value = data[0].id
                document.getElementById(locale).value = data.name
                //document.getElementById('id_discipline').value = data[0].description
                //document.getElementById('numeroAulas').value = data[0].amount
                //document.getElementById('corDestaque').value = data[0].color
            }
        })
        .catch(error => console.log(error))
}

async function getDataTeacherDiscipline(id) {
    await axios.get(`${URL_BASE}/teacher/listDisciplinesByTeacher/${id}`)
    .then(response => {
        const data = response.data;

        console.log(data);
        if (data) {
            //editModal.show();
            //document.getElementById('idEdit').value = data[0].id
            document.getElementById('disc').innerHTML = `${listRowDisciplines(data)}`
            
            //document.getElementById('id_discipline').value = data[0].description
            //document.getElementById('numeroAulas').value = data[0].amount
            //document.getElementById('corDestaque').value = data[0].color
        }
    })
    .catch(error => console.log(error))
}
function listRowDisciplines(data) {

    let row = '';    
    if(data != null){
        data.forEach( e => {            
            row += ` <div class="form-check-inline radio-toolbar text-white" style="background-color:${e.color}; border-radius: 5px;">            
                        <input name="nDisciplines[]" value="${e.id}" type="checkbox" id="flexSwitch${e.id}">
                        <label class="form-check-label" for="flexSwitch${e.id}">
                            <div class="rotulo">
                                <span class="abbreviation font-weight-bold">${e.abbreviation}</span>
                                <span class="icon-delete"><i class="fa fa-book" aria-hidden="true"></i></span>
                            </div>
                        </label>
                    </div>`
        })
    }
    return row;
}
const addAllocationTeacher = (id) => {

    addAllocationModal.show();
    addAllocationForm.reset();
    document.getElementById('idTeacherAllocation').value = id
    getDataTeacher(id,'nameAllocation');
    getDataTeacherDiscipline(id)
    // usar aqui document.querySelector("#disc").innerHTML = `${listRowDisciplines(csa)}`
    document.getElementById('msgAlertErrorAllocation').innerHTML = '';
    document.getElementById('fieldlertErrorDayWeek').innerHTML = '';
    document.getElementById('fieldlertErrorPosition').innerHTML = ''
    document.getElementById('fieldlertErrorDisciplines').innerHTML = ''
    document.getElementById('fieldlertErrorShift').innerHTML = ''

    
    // document.getElementById('msgAlertError').innerHTML = ''
    // document.getElementById('fieldlertErrorname').innerHTML = ''
    // document.getElementById('fieldlertErroramount').innerHTML = ''
    // document.getElementById('fieldlertErrordisciplines').innerHTML = ''
    // document.getElementById('fieldlertErrorcolor').innerHTML = ''


    // $('#addAllocationModal').on('shown.bs.modal', function () {
    //     $('#name').trigger('focus');
    // });

}

if (addAllocationForm) {
    addAllocationForm.addEventListener("submit", async (e) => {
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


        
        const dataForm = new FormData(addAllocationForm);
        await axios.post(`${URL_BASE}/allocation/create`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            console.log(response.data.id_teacher);
            if (response.data.error) {
                    console.log(response.data.msg)
                    document.getElementById('msgAlertErrorAllocation').innerHTML = response.data.msg
                    //document.getElementById("msgAlertSuccess").innerHTML = "";
                    //document.getElementById('idTeac').value = id
                    //document.getElementById('msgAlertError').innerHTML = response.data.msg
                    //loadToast('oi','oila','danger');

                    //validateErros(response.data.msgs.name, 'fieldlertErrorname')
                    // if(response.data.error.code == 1062){
                    //     validateErros(response.data.msgs.disciplinesTeacher, 'fieldlertErrordisciplinesTechDisc')
                    // }
                    validateErros(response.data.msgs.nDayWeek, 'fieldlertErrorDayWeek')
                    validateErros(response.data.msgs.nDisciplines, 'fieldlertErrorDisciplines')
                    validateErros(response.data.msgs.nPosition, 'fieldlertErrorPosition')
                    validateErros(response.data.msgs.nShift, 'fieldlertErrorShift')

                    //addForm.reset()
                    

                } else {
                    document.getElementById('msgAlertErrorAllocation').innerHTML = '';
                    addAllocationForm.reset();
                    addAllocationModal.hide();
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

const listAllocationModal = new bootstrap.Modal(document.getElementById('listAllocationModal'));

// const listAllocationTeacherDiscipline = (id) => {

//     listAllocationModal.show();
//     document.querySelector("#tb_teacher > tbody").innerHTML = `${loadDataTeacher(data)}`;

// } 

const listAllocationTeacherDiscipline = async (id) => {

    listAllocationModal.show();

    await axios.get(`${URL_BASE}/allocation/showTeacher/${id}`)
    .then(response => {
        const data = response.data;

        console.log(data);
        if (data) {
            //editModal.show();
            //document.getElementById('idEdit').value = data[0].id
            //document.getElementById('disc').innerHTML = `${listRowDisciplines(data)}`
            document.querySelector("#tb_allocation > tbody").innerHTML = `${loadDataAllocation(data)}`;
            //document.getElementById('id_discipline').value = data[0].description
            //document.getElementById('numeroAulas').value = data[0].amount
            //document.getElementById('corDestaque').value = data[0].color
        }
    })
    .catch(error => console.log(error))


}

const loadDataAllocation = (data)=> {
    let row = "";
    let rowAllocation = '';

    data.forEach((el, indice) => {
        console.log(data)

        if(el.situation == 'L'){            
            rowAllocation = `<a href="#" class="btn btn-dark btn-sm" onclick="delAllocationTeacher(${el.id},${el.dayWeek})">
            <i class="fa fa-trash" aria-hidden="true"></i></a>`
        } else {
            rowAllocation = `<a href="#" class="btn btn-dark btn-sm disabled">
            <i class="fa fa-trash" aria-hidden="true"></i></a>`;

        }

        let ticket = rowAllocation;

        // // if (element.status === "A") {
        // //     console.log(element.status)
        // //     ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="activeSeries(${element.id})"><i class="fa fa-check-circle"></i> Desativar</a>`;
        // // }
        row +=
            `<tr>
                <td class="align-middle">${indice + 1}</td>
                <td class="align-middle">${convertDayWeek(el.dayWeek)}</td>   
                <td class="align-middle"><div class="text-white ticket-small" style="background-color:${el.color}">${el.abbreviation}</div></td>                     
                <td class="align-middle">${el.position} ª AULA </td>                     
                <td class="align-middle">${convertSituation(el.situation)} <br><p class="badge badge-secondary" id="ocupation${el.id}">${getOcupationSchedule(el.id,el.situation)}</p></td>                     
                <td class="align-middle">${convertShift(el.shift)}</td>                     
                <td class="align-middle">${ticket}</td>        
            </tr>`;

    });
    return row;
}

async function getOcupationSchedule(idAllocation,situation) {   

    let a = '';
    console.log(idAllocation);

    //if(situation === 'O') {
        await axios.get(`${URL_BASE}/horario/api/getOcupationSchedule/${idAllocation}`)
        .then(
            response => {
            const data = response.data;
    
            if (data != null) {
                console.log(data.description);

                //return data.id_series
                //editModal.show();
                //document.getElementById('idEdit').value = data[0].id
                //document.getElementById('disc').innerHTML = `${listRowDisciplines(data)}`               
                document.querySelector(`#ocupation${idAllocation}`).innerHTML =  `Série :: ${data.description}º ${data.classification}`
                //document.getElementById('numeroAulas').value = data[0].amount
                //document.getElementById('corDestaque').value = data[0].color
            } else {
                document.querySelector(`#ocupation${idAllocation}`).innerHTML=  ''
            }
        }
        )
        .catch(error => console.log(error))
    //} else {
   // }
    //return a;
}
const delAllocationTeacherModel = new bootstrap.Modal(document.getElementById('delAllocationTeacherModal'));

async function delAllocationTeacher(idAllocationDel, dayWeekAllocationDel) {
    delAllocationTeacherForm.reset();
    document.getElementById('idAllocationDel').value = idAllocationDel
    
    await axios.get(`${URL_BASE}/allocation/show/${idAllocationDel}`)
    .then(response => {
        const data = response.data;
        
        console.log(data);
        if (data) {
            //editModal.show();
            //document.getElementById('idEdit').value = data[0].id
            //document.getElementById('disc').innerHTML = `${listRowDisciplines(data)}`
            document.getElementById('dataAllocation').innerHTML = `
                        <div class="text-white ticket-small" style="background-color:${data[0].color}">
                            <div class="rotulo">
                                <span class="abbreviation font-weight-bold">${convertDayWeek(data[0].dayWeek)} - ${data[0].position}ª Aula</span>
                                <span class="icon-delete"><i class="fa fa-book" aria-hidden="true"></i></span>
                                <br>
                                </div>
                                <p>${data[0].abbreviation}</p>
                        </div>`
            document.getElementById('id_teacher').value = data[0].id_teacher
            //document.getElementById('numeroAulas').value = data[0].amount
            //document.getElementById('corDestaque').value = data[0].color
        }
    })
    .catch(error => console.log(error))    
    
    delAllocationTeacherModel.show() 
    
}

const delAllocationTeacherForm = document.getElementById('delAllocationTeacherForm');
if (delAllocationTeacherForm) {
    
    delAllocationTeacherForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dataForm = new FormData(delAllocationTeacherForm);

        console.log(dataForm.get('id_teacher'));
        console.log(dataForm.get('id'));
        const id = dataForm.get('id');

        await axios.post(`${URL_BASE}/allocation/del`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                if (response.data.error) {
                    document.getElementById('msgAlertError').innerHTML = response.data.msg
                    document.getElementById('fieldlertError').textContent = 'Preenchimento obrigatório!'
                    document.getElementById("msgAlertSuccess").innerHTML = "";
                } else {
                    // console.log('deu certo')
                    // document.getElementById('msgAlertError').innerHTML = '';
                    // document.getElementById('fieldlertError').textContent = '';
                    // //editModal.hide();
                    // document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                    delAllocationTeacherModel.hide();
                    listAllocationModal.hide();
                    //loada();
                    //location.reload();
                    //listAllocationTeacherDiscipline(dataForm.get('id_teacher'))
                    
                    loadToast(titleSuccess, bodySuccess, success);
                }
            })
            .catch(error => console.log(error))

    });



}
