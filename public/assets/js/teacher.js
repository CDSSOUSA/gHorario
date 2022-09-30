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
        console.log(data)

        if (element.disciplines) {
            rowAllocation = ` <h6 class="dropdown-header text-left"><i></i>Alocação</h6>
            <a href="#" class="dropdown-item btn-sm" onclick="addAllocationTeacher(${element.id})">
                                <i class="fa fa-plus" aria-hidden="true"></i> Nova </a>`
        } else {
            rowAllocation = '';

        }

        if (element.allocation) {
            rowAllocation += ` <a href="#" class="btn btn-dark btn-sm dropdown-item" onclick="listAllocationTeacherDiscipline(${element.id})">
            <i class="fa fa-list" aria-hidden="true"></i> Ver alocações</a> `
        }

        let ticket = ` <h6 class="dropdown-header text-left"><i class="fa fa-book"></i> Disciplina</h6><a href="#" class="btn btn-dark btn-sm dropdown-item" onclick="addTeacherDiscipline(${element.id})">
        <i class="fa fa-plus" aria-hidden="true"></i> Nova</a> <div class="dropdown-divider"></div>
        ${rowAllocation}
        <div class="dropdown-divider"></div>
        <h6 class="dropdown-header text-left"><i class="fa fa-user"></i> Professor ::</h6>
        <a href="#" class="btn btn-dark btn-sm dropdown-item" onclick="editTeacher(${element.id})">
        <i class="fa fa-pen" aria-hidden="true"></i> Editar</a>
        <a href="#" class="btn btn-dark btn-sm dropdown-item" onclick="delTeacher(${element.id})">
        <i class="fa fa-trash" aria-hidden="true"></i> Excluir</a>
        
        `;

        // if (element.status === "A") {
        //     console.log(element.status)
        //     ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="activeSeries(${element.id})"><i class="fa fa-check-circle"></i> Desativar</a>`;
        // }
        row +=
            `<tr>
                <td class="align-middle text-sm font-weight-bold">${indice + 1}</td>
                <td class="align-middle text-sm font-weight-bold">${element.name}</td>   
                <td class="text-left text-sm font-weight-bold discipline">${document.getElementsByClassName("discipline").innerHTML = listRowDisciplinesTeacher(element.disciplines)}</td>                     
                <td class="align-middle">                
                        <div class="dropdown dropstart">
                             <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu">
                                ${ticket}
                            </div>
                        </div>
                </td>        
            </tr>`;

    });
    return row;
}

function listRowDisciplinesTeacher(data) {
    let row = '';
    if (data != null) {
        data.forEach(e => {
            row += `   <div class="discipline-ticket">               
                            <div class="d-flex m-1 p-2 w-35" style="background-color:${e.color}; color:white; border-radius: 5px;" onclick="editTeacherDiscipline(${e.id})" title="Clique para editar!">
                                <div>
                                    <img src="${URL_BASE}/assets/img/${e.icone}" width="25px"  class="me-3 border-radius-lg m-2" alt="spotify">
                                </div>
                                <div class="my-auto">
                                    <h6 class="mb-0 text-sm font-weight-bold"> ${e.abbreviation}</h6>
                                    ${e.amount} - Aula(s) 
                                </div>                    
                            </div>
                        </div>
                    ` ;
        })
    } else {

        row = `<div><div class="rounded m-1 p-2 w-35" style="background-color:#C5CCC7; color:white;border-radius: 5px; #EAEAEA solid">
        SEM <br> DISCIPLINA 
     </div></div>`
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
        $('#nameTeacherAdd').trigger('focus');
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

const editTeacherModal = new bootstrap.Modal(document.getElementById('editTeacherModal'));

async function editTeacher(id) {

    await axios.get(`${URL_BASE}/teacher/edit/${id}`)
        .then(response => {
            const data = response.data;
            console.log(data);
            if (data) {
                editTeacherModal.show()
                document.getElementById('idTeacherEdit').value = data.id
                document.getElementById('nameEdit').value = data.name
                document.getElementById('msgAlertErrorEditTeacher').innerText = ''
                document.getElementById('fieldlertErrorEditName').innerText = ''
            }
        })
        .catch()

}


const editTeacherForm = document.getElementById('editTeacherForm');
console.log(editTeacherForm);

if (editTeacherForm) {
    editTeacherForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const dataForm = new FormData(editTeacherForm);
        await axios.post(`${URL_BASE}/teacher/update`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                console.log(response.data);
                if (response.data.error) {
                    document.getElementById('msgAlertErrorEditTeacher').innerHTML = response.data.msg
                    validateErros(response.data.msgs.name, 'fieldlertErrorEditName')
                } else {
                    editTeacherModal.hide();

                    loadToast(titleSuccess, bodySuccess, success);
                    //loada(); 
                    //location.reload();
                    listTeacDisc();
                }
            })
            .catch(error => console.log(error))

    })
}


const editModal = new bootstrap.Modal(document.getElementById('editTeacherDisciplineModal'));

async function editTeacherDiscipline(id) {
    document.getElementById('msgAlertError').innerHTML = '';
    document.getElementById('fieldlertError').textContent = '';
    document.getElementById('btnDelete').textContent = '';

    await axios.get(URL_BASE + '/teacDisc/edit/' + id)
        .then(response => {
            const data = response.data;
            console.log(data);
            if (data) {
                editModal.show();
                document.getElementById('idEdit').value = data[0].id
                document.getElementById('nameTeacherDisciEdit').value = data[0].name
                document.getElementById('id_discipline').value = data[0].description
                document.getElementById('numeroAulas').value = data[0].amount
                document.getElementById('corDestaque').value = data[0].color
                document.getElementById('headerModal').style.backgroundColor = data[0].color
                document.getElementById('headerModal').style.color = '#FFF'
                if (data[0].amount_allocation == 0) {
                    document.getElementById('btnDelete').innerHTML = `<a herf="#" class="btn btn-danger" onclick="delTeacherDiscipline(${id})"><i class="fa fa-trash"></i> Excluir </a>`
                }
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
    getDataTeacher(id, 'nameDiscipline');
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

async function getDataTeacher(id, locale) {

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
                document.getElementById('heardAlocationModel').style.backgroundColor = data[0].color
                document.getElementById('heardAlocationModel').style.color = '#FFF'
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
    if (data != null) {
        data.forEach(e => {
            row += ` <div class="form-check-inline radio-toolbar text-white  m-1 p-0" style="background-color:${e.color}; border-radius: 5px; margin: 5px; width: 120px;">            
                        <input name="nDisciplines[]" value="${e.id}" type="checkbox" id="flexSwitch${e.id}">
                        <label class="form-check-label" for="flexSwitch${e.id}">
                            <div class="d-flex">
                                <div>
                                    <img src="${URL_BASE}/assets/img/${e.icone}" width="28px" class="me-3 border-radius-lg p-1" alt="spotify">
                                </div>
                                <div class="my-auto">
                                    <h6 class="mb-0 text-sm"> ${e.abbreviation}</h6>
                                </div>
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
    getDataTeacher(id, 'nameAllocation');
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
                document.querySelector("#tb_allocationa > tbody").innerHTML = `${loadDataSchedule(data)}`;
                //document.getElementById('id_discipline').value = data[0].description
                //document.getElementById('numeroAulas').value = data[0].amount
                //document.getElementById('corDestaque').value = data[0].color
                getDataTeacher(id, 'nameDisciplineAllocation');
            }
        })
        .catch(error => console.log(error))


}

function loadDataSchedule(data) {

    let row = "";
    // let dayShow = '';
    // let rowColor = '';
    for (let ps = 1; ps < 7; ps++) {
        row += `<tr>
                <th scope="row" class="text-center align-middle">${ps}ª aula</th>`

        // let dayShow = ps === 1 ? convertDayWeek(dw) : '';           
        // let rowColor = dw % 2 === 0 ? 'table-secondary' : 'table-success'

        for (let dw = 2; dw < 7; dw++) {
            //row += `<th scope="row">${dw}${ps}</th>`
            row += `<td>`
            data.forEach((elem, indice) => {

                if (elem.situation == 'O' && elem.dayWeek == dw && elem.position == ps) {
                    row += elem.abbreviation
                } else {
                    //row += `<td id="row${ps}${dw}${elem.id}" class="text-left">NÃO</td>`
                }

            })
            row += `</td>`


        }
        row += `</tr>`
    }


    return row;
}

function listDPS(idSerie, day, position, shift) {
    axios.get(`${URL_BASE}/horario/api/listDPS/${idSerie}/${day}/${position}/${shift}`)
        .then(response => {

            if (response.data == 'vago') {
                document.getElementById(`row${position}${day}${idSerie}`).innerHTML = `
            
            <div class="d-flex m-1 p-2 w-120" style="background-color: transparent; border: 1px solid #9a9a9c; color:black; border-radius: 5px;" data-toggle="tooltip" data-placement="top" title="Aguardando alocação!">
            <div>
                <img src="${URL_BASE}/assets/img/discipline-vague.png" width="28px" class="me-3 border-radius-lg m-2" alt="spotify">
            </div>
            <div class="my-auto">
                <h6 class="mb-0 text-sm font-weight-bold"> VAGO</h6>
            </div>
        </div>`
            } else if (response.data != 'livre') {
                console.log(response.data);
                document.getElementById(`row${position}${day}${idSerie}`).innerHTML = `
            <a href="#" onclick = "deleteSchedule(${response.data.id})" data-toggle="modal" data-placement="top" title="Clique para remover!">
            <div class="d-flex m-1 p-2 w-120" style="background-color: ${response.data.color}; color:white; border-radius: 5px;">
            <div>
                <img src="${URL_BASE}/assets/img/${response.data.icone}" width="28px" class="me-3 border-radius-lg m-2" alt="spotify">
            </div>
            <div class="my-auto">
                <h6 class="mb-0 font-weight-bold font-size-11"> ${response.data.name.split(" ", 1)}</h6>
                <span class="mb-0 font-weight-bold text-sm">${response.data.abbreviation}</span>
            </div>
        </div></a>`
                //loadDisc(response.data)
            } else {
                document.getElementById(`row${position}${day}${idSerie}`).innerHTML = `
            <a href="#" onclick = "addSchedule(${idSerie},${position},${day},'${shift}')" data-toggle = "modal" title="Clique para adicionar!">
            <div class="d-flex m-1 p-2 w-120" style="background-color: #343a40; color:white; border-radius: 5px;">
            <div>
                <img src="${URL_BASE}/assets/img/discipline-default.png" width="28px" class="me-3 border-radius-lg m-2" alt="spotify">
            </div>
            <div class="my-auto">
                <h6 class="mb-0 text-sm font-weight-bold"> LIVRE</h6>
            </div>
        </div></a>`
            }


        })
        .catch(error => console.log(error))

}

const loadDataAllocation = (data) => {
    let row = "";
    let rowAllocation = `<a href="#" class="btn btn-dark btn-sm disabled">
    <i class="fa fa-trash" aria-hidden="true"></i></a>`;
    let l = "";

    data.forEach((el, indice) => {
        console.log(data)

        if (el.situation == 'L') {
            rowAllocation = `<a href="#" class="btn btn-dark btn-sm" onclick="delAllocationTeacher(${el.id},${el.dayWeek})">
            <i class="fa fa-trash" aria-hidden="true"></i></a>`
            l = `<span class="badge badge-sm bg-gradient-success">${convertSituation(el.situation)}</span>`
        } else if (el.situation == 'B') {
            l = `<span class="badge badge-sm bg-gradient-danger">${convertSituation(el.situation)}</span>`
        }

        let ticket = rowAllocation;

        // // if (element.status === "A") {
        // //     console.log(element.status)
        // //     ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="activeSeries(${element.id})"><i class="fa fa-check-circle"></i> Desativar</a>`;
        // // }

        row +=
            `<tr>
                <td class="align-middle">${indice + 1}</td>                  
                <td class="align-middle">
                
                                        <div class="text-white m-2 p-2 w-35" style="background-color:${el.color}; border-radius: 5px; margin: 5px;">
                 
                                        <div class="d-flex">
                                        <div>
                                            <img src="${URL_BASE}/assets/img/${el.icone}" width="30px" class="me-3 border-radius-lg p-1" alt="spotify">
                                        </div>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm"> ${el.abbreviation} - ${el.name.split(" ", 1)} </h6>
                                            <span class="text-sm">${convertDayWeek(el.dayWeek)} - ${el.position} ª AULA - ${convertShift(el.shift)}</span>
                                        </div>
                                    </div>                     
                                        
                                        </td>
                <td class="align-middle">${l}<p id="ocupation${el.id}">${getOcupationSchedule(el.id, el.situation)}</p></td>                     
                <td class="align-middle">${ticket}</td>        
            </tr>`;

    });
    return row;
}

async function getOcupationSchedule(idAllocation, situation) {

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
                    document.querySelector(`#ocupation${idAllocation}`).innerHTML = `<span class="badge badge-sm bg-gradient-secondary">OCUPADO <br>Série :: ${data.description}º ${data.classification}</span>`
                    //document.getElementById('numeroAulas').value = data[0].amount
                    //document.getElementById('corDestaque').value = data[0].color
                } else {
                    document.querySelector(`#ocupation${idAllocation}`).innerHTML = ''
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

                <div class="text-white m-2 p-2 w-35" style="background-color:${data[0].color}; border-radius: 5px; margin: 5px;">
                 
                                        <div class="d-flex">
                                        <div>
                                            <img src="${URL_BASE}/assets/img/${data[0].icone}" width="30px" class="me-3 border-radius-lg p-1" alt="spotify">
                                        </div>
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm"> ${data[0].abbreviation} - ${data[0].name.split(" ", 1)} </h6>
                                            <span class="text-sm">${convertDayWeek(data[0].dayWeek)} - ${data[0].position} ª Aula - ${convertShift(data[0].shift)}</span>
                                        </div>
                                    </div>        

                        `
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

const deleteModal = new bootstrap.Modal(document.getElementById('deleteTeacherDisciplineModal'));
async function delTeacherDiscipline(id) {
    await axios.get(URL_BASE + '/teacDisc/delete/' + id)
        .then(response => {
            const data = response.data;
            if (data) {
                console.log(data);

                deleteModal.show();
                document.getElementById('idDelete').value = data[0].id
                document.getElementById('dataDeleteTeacDisc').innerHTML = `<div class="rounded m-1 p-2 w-25" style="background-color:${data[0].color}; color:white; border:1px #EAEAEA solid">
                ${data[0].abbreviation} :: <br> ${data[0].amount} - Aula(s) 
             </div>`

            }
        })
        .catch(error => console.log(error))
    //deleteModal.show()
}

const deleteForm = document.getElementById('deleteTeacherDisciplineForm');
console.log(deleteForm);


if (deleteForm) {

    deleteForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const dataForm = new FormData(deleteForm);

        await axios.post(`${URL_BASE}/teacDisc/del`, dataForm, {
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

                    document.getElementById('msgAlertError').innerHTML = '';
                    document.getElementById('fieldlertError').textContent = '';
                    deleteModal.hide();
                    editModal.hide();
                    //document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                    //location.reload();
                    loadToast(titleSuccess, bodySuccess, success);
                    //loada(); 
                    //location.reload();
                    listTeacDisc();

                }
            })
            .catch(error => console.log(error))
    })
}

const deleteTeacherModal = new bootstrap.Modal(document.getElementById('deleteTeacherModal'));
async function delTeacher(id) {
    // await axios.get(URL_BASE + '/teacher/delete/' + id)
    //     .then(response => {
    //         const data = response.data;
    //         if (data) {
    //             console.log(data);

    deleteTeacherModal.show();
    document.getElementById('idDeleteTeacher').value = id
    getDataTeacher(id, 'nameTeacher')
    //          </div>`

    //         }
    //     })
    //     .catch(error => console.log(error))
    // //deleteModal.show()
}

const deleteTeacherForm = document.getElementById('deleteTeacherForm');

if (deleteTeacherForm) {

    deleteTeacherForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const dataForm = new FormData(deleteTeacherForm);

        await axios.post(`${URL_BASE}/teacher/del`, dataForm, {
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

                    document.getElementById('msgAlertError').innerHTML = '';
                    document.getElementById('fieldlertError').textContent = '';
                    deleteTeacherModal.hide();
                    //document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                    //location.reload();
                    loadToast(titleSuccess, bodySuccess, success);
                    //loada(); 
                    //location.reload();
                    listTeacDisc();

                }
            })
            .catch(error => console.log(error))
    })
}