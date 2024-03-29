var divLoad = document.querySelector('#load');
var divLoader = document.querySelector('#loader');
var titleSuccess = '<strong class="me-auto">Parabéns!</strong>';
var bodySuccess = ' Operação realizada com sucesso';
var success = 'success';
//const URL_BASE = 'http://localhost/gerenciador-horario/public';

listSeries();

async function listSeries() {
    await axios.get(`${URL_BASE}/series/list`)
        .then(response => {
            const data = response.data;
            console.log(data);
            document.querySelector("#tb_series > tbody").innerHTML = `${loadDataSeries(data)}`;
            //loadDataTable(data)
        }
        )
        .catch(error => console.log(error))
}

function loadDataSeries(data) {
    let row = "";

    data.forEach((element, indice) => {
        //console.log(data)

        let ticket = `<a href="#" class="btn btn-outline-dark" onclick="activeSeries(${element.id})" title="Ativar série"><i class="fa fa-check" aria-hidden="true"></i></a>
        <a href="#" class="btn btn-outline-dark disabled" title="Editar série"><i class="fa fa-pen"></i></a>`;

        if (element.status === "A") {
            console.log(element.status)
            ticket = `<a href="#" class="btn btn-outline-dark" onclick="activeSeries(${element.id})" title="Desativar série"><i class="fa fa-trash"></i></a>
            <a href="#" class="btn btn-outline-dark" onclick="editSeries(${element.id})" title="Editar série"><i class="fa fa-pen"></i></a>
            <a class="btn btn-outline-dark" onclick="printReportSerie(${element.id})" title="Horário por série"><i class="fa fa-th"></i></a>`;
        }
        row +=
            `<tr>
                <td class="align-middle text-sm font-weight-bold">${indice + 1}</td>
                <td class="align-middle text-sm font-weight-bold">${element.description}º ${element.classification} - ${convertShift(element.shift)} </td>
                <td class="align-middle text-sm font-weight-bold">${convertStatus(element.status)}</td>           
                <td>${ticket}</td>        
            </tr>`;

    });
    return row;
}

const addSeriesModal = new bootstrap.Modal(document.getElementById('addSeriesModal'));
const addSeriesForm = document.getElementById('addSeriesForm');
async function addSeries() {

    addSeriesModal.show();
    document.getElementById('msgAlertError').innerHTML = ''
    document.getElementById('fieldlertErrordescription').innerHTML = ''
    document.getElementById('fieldlertErrorclassification').innerHTML = ''
    document.getElementById('fieldlertErrorshift').innerHTML = ''
    document.getElementById('fieldlertDuplicative').innerHTML = ''
   
    //document.getElementById('fieldlertError').textContent = ''

    addSeriesForm.reset();

    $('#addSeriesModal').on('shown.bs.modal', function () {
        $('#description').trigger('focus');
    });

}
console.log(addSeriesForm);
if (addSeriesForm) {
    addSeriesForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        //load();
        const dataForm = new FormData(addSeriesForm);
        await axios.post(`${URL_BASE}/series/create`, dataForm, {
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
                    validateErros(response.data.msgs.description, 'fieldlertErrordescription')
                    validateErros(response.data.msgs.classification, 'fieldlertErrorclassification')
                    validateErros(response.data.msgs.shift, 'fieldlertErrorshift')
                    validateErros(response.data.msgs.series, 'fieldlertDuplicative') 
                    //if(response.data.msgs.description){
                    //     document.getElementById('fieldlertErrorDescription').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`
                    // } else {
                    //     document.getElementById('fieldlertErrorDescription').innerHTML ='';
                    // }

                } else {
                    // load();
                    // //console.log(response.data)
                    // location.reload();
                    addSeriesModal.hide();
                    addSeriesForm.reset();
                    loadToast(titleSuccess, bodySuccess, success);
                    //loadDataTable(response.data)
                    //loada();
                    listSeries();

                }
            })
            .catch(error => console.log(error))
    });
}




const activeSeriesModal = new bootstrap.Modal(document.getElementById('activeSeriesModal'));

async function activeSeries(id) {

    activeSeriesModal.show();
    document.getElementById('id').value = id;

    getSeriess(id, 'descriptionFake');

}

const activeSerieForm = document.getElementById('activeSerieForm');

if (activeSerieForm) {

    activeSerieForm.addEventListener('submit', async (e) => {

        e.preventDefault();

        const dataForm = new FormData(activeSerieForm);
        await axios.post(`${URL_BASE}/series/active`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {

                console.log(response.data)
                if (response.data.error) {
                    console.log(response.data)
                    document.getElementById('msgAlertError').innerHTML = response.data.msg
                    document.getElementById('fieldlertError').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`
                    
                } else {
                    // load();
                    // //console.log(response.data)
                    // location.reload();
                    activeSeriesModal.hide();
                    activeSerieForm.reset();
                    loadToast(titleSuccess, bodySuccess, success);
                    //loadDataTable(response.data)
                    //loada();
                    listSeries();
                }

            })
            .catch(error => console.log(error))
    })


}

async function getSeriess(id, locale) {

    await axios.get(`${URL_BASE}/series/show/${id}`)
        .then(response => {
            console.log(response.data)
            document.getElementById(locale).value = `${response.data[0].description}º ${response.data[0].classification} - ${convertShift(response.data[0].shift)}`
            document.getElementById('status').value = response.data[0].status
            document.getElementById('activeSeriesModalLabel').innerHTML = `<i class="fa fa-users"></i> ${convertStatusRotulo(response.data[0].status)} série`
        })
        .catch(error => console.log(error))
}

const editSerieModal = new bootstrap.Modal(document.getElementById('editSerieModal'));
const editSerieForm = document.getElementById('editSerieForm');
async function editSeries(id) {

    await axios.get(`${URL_BASE}/series/edit/${id}`)
        .then(response => {
            const data = response.data;
            console.log(data);
            if (data) {
                editSerieModal.show()
                editSerieForm.reset()
                document.getElementById('idSerieEdit').value = id
                document.getElementById('descriptionEdit').value = data[0].description
                document.getElementById('classificationEdit').value = data[0].classification
                                
                const select = document.querySelector('#shift');
                const optionShift = data[0].shift;
               
                if(select.options.length > 1) {
                    document.querySelector('#shift option[value=M]').remove();
                    document.querySelector('#shift option[value=T]').remove();
                }
                if(optionShift === 'M') {                   
                    select.options[select.options.length] = new Option('Manhã','M');
                    select.options[select.options.length] = new Option('Tarde','T');
                    
                   
                } else {                    
                    select.options[select.options.length] = new Option('Tarde','T');
                    select.options[select.options.length] = new Option('Manhã','M');
                }
               
                // document.getElementById('nameEdit').value = data.name
                // document.getElementById('msgAlertErrorEditTeacher').innerText = ''
                // document.getElementById('fieldlertErrorEditName').innerText = ''
            }
        })
        .catch()

}

if (editSerieForm) {
    editSerieForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dataForm = new FormData(editSerieForm);
        await axios.post(`${URL_BASE}/series/update`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            console.log(response.data);
            if (response.data.error) {
                document.getElementById('msgAlertErrorEditSerie').innerHTML = response.data.msg
                //validateErros(response.data.msgs.name, 'fieldlertErrorEditName')
            } else {
                editSerieModal.hide();

                loadToast(titleSuccess, bodySuccess, success);
                //loada(); 
                //location.reload();
                listSeries();
            }
        })

    })
}


// const addYearSchoolModal = new bootstrap.Modal(document.getElementById('addYearSchoolModal'));
// const activateYearSchoolModal = new bootstrap.Modal(document.getElementById('activateYearSchoolModal'));
// const addYearSchoollForm = document.getElementById('addYearSchoolForm');

// async function addYearSchool() {
//     document.getElementById('msgAlertError').innerHTML = ''
//     document.getElementById('fieldlertError').textContent = ''

//     addYearSchoolModal.show();
//     addYearSchoollForm.reset();

//     $('#addYearSchoolModal').on('shown.bs.modal', function () {
//         $('#description').trigger('focus');
//     });

//     //document.getElementById('description').focus();
//     // document.getElementById('position').value = position
//     // document.getElementById('dayWeek').value = dayWeek
//     // document.getElementById('shift').value = shift
//     // document.getElementById('shiftFake').innerText = convertShift(shift)
//     // document.getElementById('dayWeekFake').innerText = convertDayWeek(dayWeek)
//     // document.getElementById('positionFake').innerText = `${position}ª`
//     // const divOpcao = document.getElementById('divOpcao')
//     // divOpcao.innerHTML = ''

//     // await axios.get(`${URL_BASE}/series/show/${idSerie}`)
//     //     .then(response => {
//     //         console.log(response.data)
//     //         document.getElementById('idSerieFake').innerText = `${response.data[0].description}º ${response.data[0].classification}`
//     //     })
//     //     .catch(error => console.log(error))

//     // getSeries(idSerie, 'idSerieFake');

//     // await axios.get(`${URL_BASE}/horario/api/getAllocation/${idSerie}/${dayWeek}/${position}/${shift}`)
//     //     .then(response => {
//     //         const data = response.data;
//     //         data.forEach(element => {
//     //             divOpcao.innerHTML += `<div class="form-check-inline radio-toolbar text-white" style="background-color:${element.color}; border-radius: 5px; margin: 5px;">
//     //          <input class="form-check-input" type="radio" id="gridCheck1${element.id}" name= "nIdAlocacao" value="${element.id}"/>
//     //         <label class="form-check-label" for="gridCheck1${element.id}">
//     //         <div class="rotulo"><span class="abbreviation font-weight-bold">${element.abbreviation}</span>
//     //         <span class="icon-delete"><i class="fa fa-unlock" aria-hidden="true"></i>
//     //         </span></div><p class="font-weight-bold">${element.name.split(" ", 1)}</p>
//     //         </label></div>`
//     //             //console.log(element);
//     //         });
//     //     })
//     //     .catch(error => console.log(error))
// }

// console.log(addYearSchoollForm);

// if (addYearSchoollForm) {
//     addYearSchoollForm.addEventListener('submit', async (e) => {
//         e.preventDefault();
//         //load();
//         const dataForm = new FormData(addYearSchoollForm);
//         await axios.post(`${URL_YEAR}/yearSchool/create`, dataForm, {
//             headers: {
//                 "Content-Type": "application/json"
//             }
//         })
//             .then(response => {
//                 //
//                 console.log(response.data)
//                 if (response.data.error) {
//                     console.log(response.data)
//                     document.getElementById('msgAlertError').innerHTML = response.data.msg
//                     document.getElementById('fieldlertError').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`

//                 } else {
//                     // load();
//                     // //console.log(response.data)
//                     // location.reload();
//                     addYearSchoolModal.hide();
//                     addYearSchoollForm.reset();
//                     loadToast(titleSuccess, bodySuccess, success);
//                     //loadDataTable(response.data)
//                     //loada();
//                     listYearSchool();

//                 }
//             })
//             .catch(error => console.log(error))
//     })
// }
// const activateYearSchoolForm = document.getElementById('activateYearSchoolForm');
// function activateYearSchool(id,description){
//     activateYearSchoolModal.show();
//     console.log(description);
//     document.getElementById('id').value = id    
//     document.getElementById('descriptionFake').value = description    
//     //addYearSchoollForm.reset();
// }
// if(activateYearSchoolForm) {
//     activateYearSchoolForm.addEventListener('submit', async (e) => {
//         e.preventDefault();
//         //load();
//         const dataForm = new FormData(activateYearSchoolForm);
//         await axios.post(`${URL_YEAR}/yearSchool/active`, dataForm, {
//             headers: {
//                 "Content-Type": "application/json"
//             }
//         })
//         .then(response => {            
//             console.log(response.data)
//             if (response.data.error) {
//                 console.log(response.data)
//                 // document.getElementById('msgAlertError').innerHTML = response.data.msg
//                 // document.getElementById('fieldlertError').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`

//             } else {
//                 // load();
//                 // //console.log(response.data)
//                 // location.reload();
//                 activateYearSchoolModal.hide();
//                 activateYearSchoolForm.reset();
//                 loadToast(titleSuccess, bodySuccess, success);
//                 //loadDataTable(response.data)
//                 //loada();
//                 listYearSchool();

//             }
//         })
//         .catch(error => console.log(error))
//     })
// }


// function loadToast(title, body, bg) {

//     $(document).Toasts('create', {
//         title: title,
//         icon: 'fas fa-exclamation-triangle',
//         class: `bg-${bg} m-1 width-500 toast`,
//         autohide: true,
//         delay: 1000,
//         body: body,
//         close: false,
//         subtitle: new Date().toLocaleDateString(),
//         autoremove: true
//     });
//     $('.toast').on('hidden.bs.toast', e => {
//         $(e.currentTarget).remove();
//         //location.reload();
//         //listYearSchool();
//         //stopLoad();
//     });
// }

// const convertShiftA = (turno) => {
//     let shift = 'TARDE'
//     if (turno === 'M')
//         shift = 'MANHÃ'
//     return shift;
// }