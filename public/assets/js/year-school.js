var divLoad = document.querySelector('#load');
var divLoader = document.querySelector('#loader');
var titleSuccess = '<strong class="me-auto">Parabéns!</strong>';
var bodySuccess = ' Operação realizada com sucesso';
var success = 'success';
const URL_YEAR = 'http://localhost/gerenciador-horario/public';

listYearSchool();

async function listYearSchool() {
    await axios.get(`${URL_YEAR}/yearSchool/list`)
        .then(response => {
            const data = response.data;
            console.log(data);
            document.querySelector("#tb_year > tbody").innerHTML = `${loadDataTable(data)}`;
            //loadDataTable(data)
        }
        )
        .catch(error => console.log(error))
}

function loadDataTable(data) {
    let row = "";

    data.forEach((element, indice) => {
        //console.log(data)
       
        let ticket = `<a href="#" class="btn btn-dark" onclick="activateYearSchool(${element.id})"><i class="fa fa-check-circle"></i> Ativar</a>`;

        if (element.status === "A") {
            console.log(element.status)
            ticket = '<button class="btn btn-default disabled"><i class="fa fa-check"></i> ATUAL </button>';           
        }
        row +=
            `<tr>
                <td>${indice + 1}</td>
                <td>${element.description}</td>
                <td>${element.status}</td>           
                <td>${ticket}</td>        
            </tr>`;

    });
    return row;
}
const addYearSchoolModal = new bootstrap.Modal(document.getElementById('addYearSchoolModal'));
const activateYearSchoolModal = new bootstrap.Modal(document.getElementById('activateYearSchoolModal'));
const addYearSchoollForm = document.getElementById('addYearSchoolForm');

async function addYearSchool() {
    document.getElementById('msgAlertError').innerHTML = ''
    document.getElementById('fieldlertError').textContent = ''

    addYearSchoolModal.show();
    addYearSchoollForm.reset();

    $('#addYearSchoolModal').on('shown.bs.modal', function () {
        $('#description').trigger('focus');
    });

    //document.getElementById('description').focus();
    // document.getElementById('position').value = position
    // document.getElementById('dayWeek').value = dayWeek
    // document.getElementById('shift').value = shift
    // document.getElementById('shiftFake').innerText = convertShift(shift)
    // document.getElementById('dayWeekFake').innerText = convertDayWeek(dayWeek)
    // document.getElementById('positionFake').innerText = `${position}ª`
    // const divOpcao = document.getElementById('divOpcao')
    // divOpcao.innerHTML = ''

    // await axios.get(`${URL_BASE}/series/show/${idSerie}`)
    //     .then(response => {
    //         console.log(response.data)
    //         document.getElementById('idSerieFake').innerText = `${response.data[0].description}º ${response.data[0].classification}`
    //     })
    //     .catch(error => console.log(error))

    // getSeries(idSerie, 'idSerieFake');

    // await axios.get(`${URL_BASE}/horario/api/getAllocation/${idSerie}/${dayWeek}/${position}/${shift}`)
    //     .then(response => {
    //         const data = response.data;
    //         data.forEach(element => {
    //             divOpcao.innerHTML += `<div class="form-check-inline radio-toolbar text-white" style="background-color:${element.color}; border-radius: 5px; margin: 5px;">
    //          <input class="form-check-input" type="radio" id="gridCheck1${element.id}" name= "nIdAlocacao" value="${element.id}"/>
    //         <label class="form-check-label" for="gridCheck1${element.id}">
    //         <div class="rotulo"><span class="abbreviation font-weight-bold">${element.abbreviation}</span>
    //         <span class="icon-delete"><i class="fa fa-unlock" aria-hidden="true"></i>
    //         </span></div><p class="font-weight-bold">${element.name.split(" ", 1)}</p>
    //         </label></div>`
    //             //console.log(element);
    //         });
    //     })
    //     .catch(error => console.log(error))
}

console.log(addYearSchoollForm);

if (addYearSchoollForm) {
    addYearSchoollForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        //load();
        const dataForm = new FormData(addYearSchoollForm);
        await axios.post(`${URL_YEAR}/yearSchool/create`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                //
                console.log(response.data)
                if (response.data.error) {
                    console.log(response.data)
                    document.getElementById('msgAlertError').innerHTML = response.data.msg
                    document.getElementById('fieldlertError').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`

                } else {
                    // load();
                    // //console.log(response.data)
                    // location.reload();
                    addYearSchoolModal.hide();
                    addYearSchoollForm.reset();
                    loadToast(titleSuccess, bodySuccess, success);
                    //loadDataTable(response.data)
                    //loada();
                    listYearSchool();

                }
            })
            .catch(error => console.log(error))
    })
}
const activateYearSchoolForm = document.getElementById('activateYearSchoolForm');
function activateYearSchool(id){
    activateYearSchoolModal.show();
    document.getElementById('id').value = id    
    //addYearSchoollForm.reset();
}
if(activateYearSchoolForm) {
    activateYearSchoolForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        //load();
        const dataForm = new FormData(activateYearSchoolForm);
        await axios.post(`${URL_YEAR}/yearSchool/active`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {            
            console.log(response.data)
            if (response.data.error) {
                console.log(response.data)
                // document.getElementById('msgAlertError').innerHTML = response.data.msg
                // document.getElementById('fieldlertError').innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${response.data.msgs.description}!`

            } else {
                // load();
                // //console.log(response.data)
                // location.reload();
                activateYearSchoolModal.hide();
                activateYearSchoolForm.reset();
                loadToast(titleSuccess, bodySuccess, success);
                //loadDataTable(response.data)
                //loada();
                listYearSchool();

            }
        })
        .catch(error => console.log(error))
    })
}


function loadToast(title, body, bg) {

    $(document).Toasts('create', {
        title: title,
        icon: 'fas fa-exclamation-triangle',
        class: `bg-${bg} m-1 width-500 toast`,
        autohide: true,
        delay: 1000,
        body: body,
        close: false,
        subtitle: new Date().toLocaleDateString(),
        autoremove: true
    });
    $('.toast').on('hidden.bs.toast', e => {
        $(e.currentTarget).remove();
        //location.reload();
        //listYearSchool();
        //stopLoad();
    });
}