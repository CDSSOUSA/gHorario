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

var ticket = '';
function loadDataDisciplines(data) {
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
            `<tr>
                <td>${indice + 1}</td>
                <td>${element.description}</td>
                <td>${element.abbreviation}</td>           
                <td class="text-center">${element.amount}</td>           
                <td>${ticket}</td>        
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

//Cria função para editar disciplina
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
    //deleteModal.show()
}


//     document.getElementById('msgAlertError').innerHTML = ''
//     document.getElementById('fieldlertErrordescription').innerHTML = ''
//     document.getElementById('fieldlertErrorclassification').innerHTML = ''
//     document.getElementById('fieldlertErrorshift').innerHTML = ''
//     document.getElementById('fieldlertDuplicative').innerHTML = ''
   
//     //document.getElementById('fieldlertError').textContent = ''

//     addSeriesForm.reset();

//     $('#addSeriesModal').on('shown.bs.modal', function () {
//         $('#description').trigger('focus');
//     });

// }
// console.log(addSeriesForm);
// if (addSeriesForm) {
//     addSeriesForm.addEventListener('submit', async (e) => {
//         e.preventDefault();
//         //load();
//         const dataForm = new FormData(addSeriesForm);
//         await axios.post(`${URL_BASE}/series/create`, dataForm, {
//             headers: {
//                 "Content-Type": "application/json"
//             }
//         })
//             .then(response => {
//                 console.log(response.data)
//                 if (response.data.error) {
//                     console.log(response.data)
//                     document.getElementById('msgAlertError').innerHTML = response.data.msg
//                     const er = response.data.msgs;
//                     console.log(er)
//                     // er.forEach( (e,indice) => {

//                     //     validateErros(e, 'fieldlertError' + indice);
//                     // })
//                     validateErros(response.data.msgs.description, 'fieldlertErrordescription')
//                     validateErros(response.data.msgs.classification, 'fieldlertErrorclassification')
//                     validateErros(response.data.msgs.shift, 'fieldlertErrorshift')
//                     validateErros(response.data.msgs.series, 'fieldlertDuplicative') 
//                     //if(response.data.msgs.description){
//                     //     document.getElementById('fieldlertErrorDescription').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`
//                     // } else {
//                     //     document.getElementById('fieldlertErrorDescription').innerHTML ='';
//                     // }

//                 } else {
//                     // load();
//                     // //console.log(response.data)
//                     // location.reload();
//                     addSeriesModal.hide();
//                     addSeriesForm.reset();
//                     loadToast(titleSuccess, bodySuccess, success);
//                     //loadDataTable(response.data)
//                     //loada();
//                     listSeries();

//                 }
//             })
//             .catch(error => console.log(error))
//     });
// }




// const activeSeriesModal = new bootstrap.Modal(document.getElementById('activeSeriesModal'));

// async function activeSeries(id) {

//     activeSeriesModal.show();
//     document.getElementById('id').value = id;

//     getSeriess(id, 'descriptionFake');

// }

// const activeSerieForm = document.getElementById('activeSerieForm');

// if (activeSerieForm) {

//     activeSerieForm.addEventListener('submit', async (e) => {

//         e.preventDefault();

//         const dataForm = new FormData(activeSerieForm);
//         await axios.post(`${URL_BASE}/series/active`, dataForm, {
//             headers: {
//                 "Content-Type": "application/json"
//             }
//         })
//             .then(response => {

//                 console.log(response.data)
//                 if (response.data.error) {
//                     console.log(response.data)
//                     document.getElementById('msgAlertError').innerHTML = response.data.msg
//                     document.getElementById('fieldlertError').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`
                    
//                 } else {
//                     // load();
//                     // //console.log(response.data)
//                     // location.reload();
//                     activeSeriesModal.hide();
//                     activeSerieForm.reset();
//                     loadToast(titleSuccess, bodySuccess, success);
//                     //loadDataTable(response.data)
//                     //loada();
//                     listSeries();
//                 }

//             })
//             .catch(error => console.log(error))
//     })


// }

// async function getSeriess(id, locale) {

//     await axios.get(`${URL_BASE}/series/show/${id}`)
//         .then(response => {
//             console.log(response.data)
//             document.getElementById(locale).value = `${response.data[0].description}º ${response.data[0].classification} - ${convertShift(response.data[0].shift)}`
//             document.getElementById('status').value = response.data[0].status
//             document.getElementById('activeSeriesModalLabel').innerHTML = `<i class="fa fa-users"></i> ${convertStatusRotulo(response.data[0].status)} série`
//         })
//         .catch(error => console.log(error))
// }

// // const addYearSchoolModal = new bootstrap.Modal(document.getElementById('addYearSchoolModal'));
// // const activateYearSchoolModal = new bootstrap.Modal(document.getElementById('activateYearSchoolModal'));
// // const addYearSchoollForm = document.getElementById('addYearSchoolForm');

// // async function addYearSchool() {
// //     document.getElementById('msgAlertError').innerHTML = ''
// //     document.getElementById('fieldlertError').textContent = ''

// //     addYearSchoolModal.show();
// //     addYearSchoollForm.reset();

// //     $('#addYearSchoolModal').on('shown.bs.modal', function () {
// //         $('#description').trigger('focus');
// //     });

// //     //document.getElementById('description').focus();
// //     // document.getElementById('position').value = position
// //     // document.getElementById('dayWeek').value = dayWeek
// //     // document.getElementById('shift').value = shift
// //     // document.getElementById('shiftFake').innerText = convertShift(shift)
// //     // document.getElementById('dayWeekFake').innerText = convertDayWeek(dayWeek)
// //     // document.getElementById('positionFake').innerText = `${position}ª`
// //     // const divOpcao = document.getElementById('divOpcao')
// //     // divOpcao.innerHTML = ''

// //     // await axios.get(`${URL_BASE}/series/show/${idSerie}`)
// //     //     .then(response => {
// //     //         console.log(response.data)
// //     //         document.getElementById('idSerieFake').innerText = `${response.data[0].description}º ${response.data[0].classification}`
// //     //     })
// //     //     .catch(error => console.log(error))

// //     // getSeries(idSerie, 'idSerieFake');

// //     // await axios.get(`${URL_BASE}/horario/api/getAllocation/${idSerie}/${dayWeek}/${position}/${shift}`)
// //     //     .then(response => {
// //     //         const data = response.data;
// //     //         data.forEach(element => {
// //     //             divOpcao.innerHTML += `<div class="form-check-inline radio-toolbar text-white" style="background-color:${element.color}; border-radius: 5px; margin: 5px;">
// //     //          <input class="form-check-input" type="radio" id="gridCheck1${element.id}" name= "nIdAlocacao" value="${element.id}"/>
// //     //         <label class="form-check-label" for="gridCheck1${element.id}">
// //     //         <div class="rotulo"><span class="abbreviation font-weight-bold">${element.abbreviation}</span>
// //     //         <span class="icon-delete"><i class="fa fa-unlock" aria-hidden="true"></i>
// //     //         </span></div><p class="font-weight-bold">${element.name.split(" ", 1)}</p>
// //     //         </label></div>`
// //     //             //console.log(element);
// //     //         });
// //     //     })
// //     //     .catch(error => console.log(error))
// // }

// // console.log(addYearSchoollForm);

// // if (addYearSchoollForm) {
// //     addYearSchoollForm.addEventListener('submit', async (e) => {
// //         e.preventDefault();
// //         //load();
// //         const dataForm = new FormData(addYearSchoollForm);
// //         await axios.post(`${URL_YEAR}/yearSchool/create`, dataForm, {
// //             headers: {
// //                 "Content-Type": "application/json"
// //             }
// //         })
// //             .then(response => {
// //                 //
// //                 console.log(response.data)
// //                 if (response.data.error) {
// //                     console.log(response.data)
// //                     document.getElementById('msgAlertError').innerHTML = response.data.msg
// //                     document.getElementById('fieldlertError').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`

// //                 } else {
// //                     // load();
// //                     // //console.log(response.data)
// //                     // location.reload();
// //                     addYearSchoolModal.hide();
// //                     addYearSchoollForm.reset();
// //                     loadToast(titleSuccess, bodySuccess, success);
// //                     //loadDataTable(response.data)
// //                     //loada();
// //                     listYearSchool();

// //                 }
// //             })
// //             .catch(error => console.log(error))
// //     })
// // }
// // const activateYearSchoolForm = document.getElementById('activateYearSchoolForm');
// // function activateYearSchool(id,description){
// //     activateYearSchoolModal.show();
// //     console.log(description);
// //     document.getElementById('id').value = id    
// //     document.getElementById('descriptionFake').value = description    
// //     //addYearSchoollForm.reset();
// // }
// // if(activateYearSchoolForm) {
// //     activateYearSchoolForm.addEventListener('submit', async (e) => {
// //         e.preventDefault();
// //         //load();
// //         const dataForm = new FormData(activateYearSchoolForm);
// //         await axios.post(`${URL_YEAR}/yearSchool/active`, dataForm, {
// //             headers: {
// //                 "Content-Type": "application/json"
// //             }
// //         })
// //         .then(response => {            
// //             console.log(response.data)
// //             if (response.data.error) {
// //                 console.log(response.data)
// //                 // document.getElementById('msgAlertError').innerHTML = response.data.msg
// //                 // document.getElementById('fieldlertError').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`

// //             } else {
// //                 // load();
// //                 // //console.log(response.data)
// //                 // location.reload();
// //                 activateYearSchoolModal.hide();
// //                 activateYearSchoolForm.reset();
// //                 loadToast(titleSuccess, bodySuccess, success);
// //                 //loadDataTable(response.data)
// //                 //loada();
// //                 listYearSchool();

// //             }
// //         })
// //         .catch(error => console.log(error))
// //     })
// // }


// // function loadToast(title, body, bg) {

// //     $(document).Toasts('create', {
// //         title: title,
// //         icon: 'fas fa-exclamation-triangle',
// //         class: `bg-${bg} m-1 width-500 toast`,
// //         autohide: true,
// //         delay: 1000,
// //         body: body,
// //         close: false,
// //         subtitle: new Date().toLocaleDateString(),
// //         autoremove: true
// //     });
// //     $('.toast').on('hidden.bs.toast', e => {
// //         $(e.currentTarget).remove();
// //         //location.reload();
// //         //listYearSchool();
// //         //stopLoad();
// //     });
// // }

// // const convertShiftA = (turno) => {
// //     let shift = 'TARDE'
// //     if (turno === 'M')
// //         shift = 'MANHÃ'
// //     return shift;
// // }