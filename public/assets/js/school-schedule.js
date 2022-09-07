var divLoad = document.querySelector('#load');
var divLoader = document.querySelector('#loader');


const addScheduleModal = new bootstrap.Modal(document.getElementById('addScheduleModal'));

var URL_BASE = 'http://localhost/gerenciador-horario/public';
console.log(URL_BASE);

async function addSchedule(idSerie, position, dayWeek, shift) {
    document.getElementById('msgAlertError').innerHTML = ''
    document.getElementById('fieldlertError').textContent = ''

    addScheduleModal.show();
    document.getElementById('idSerie').value = idSerie
    document.getElementById('position').value = position
    document.getElementById('dayWeek').value = dayWeek
    document.getElementById('shift').value = shift
    const divOpcao = document.getElementById('divOpcao')
    divOpcao.innerHTML = ''

    await axios.get(`${URL_BASE}/horario/api/getAllocation/${idSerie}/${dayWeek}/${position}/${shift}`)
        .then(response => {
            const data = response.data;
            data.forEach(element => {
                divOpcao.innerHTML += `<div class="form-check-inline radio-toolbar text-white" style="background-color:${element.color}; border-radius: 5px; margin: 5px;">
             <input class="form-check-input" type="radio" id="gridCheck1${element.id}" name= "nIdAlocacao" value="${element.id}"/>
            <label class="form-check-label" for="gridCheck1${element.id}">
            <div class="rotulo"><span class="abbreviation font-weight-bold">${element.abbreviation}</span>
            <span class="icon-delete"><i class="fa fa-unlock" aria-hidden="true"></i>
            </span></div><p>${element.name.split(" ", 1)}</p>
            </label></div>`
                //console.log(element);
            });
        })
        .catch(error => console.log(error))
}

const addScheduleForm = document.getElementById('addScheduleForm');
console.log(addScheduleForm);

if (addScheduleForm) {
    addScheduleForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        load();
        const dataForm = new FormData(addScheduleForm);        
        await axios.post(`${URL_BASE}/horario/api/create`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                stopLoad();
                if (response.data.error) {
                    console.log('errro')
                    document.getElementById('msgAlertError').innerHTML = response.data.msg
                    document.getElementById('fieldlertError').textContent = 'Escolha obrigatória!'

                } else {
                    // load();
                    // //console.log(response.data)
                    // location.reload();
                    addScheduleModal.hide();
                    loadToast(titleSuccess, bodySuccess, success);                        
                    loada(); 
                }
            })
            .catch(error => console.log(error))
    })
}

const deleteScheduleModal = new bootstrap.Modal(document.getElementById('deleteScheduleModal'));

async function deleteSchedule(id) {
    await axios.get(`${URL_BASE}/horario/api/delete/${id}`)
    .then(response => {
        const data = response.data;
        console.log(data);
        if (data) {           
            deleteScheduleModal.show();
            document.getElementById('idDelete').value = data.id
        }
    })
    .catch(error => console.log(error))

}

const deleteScheduleForm = document.getElementById('deleteScheduleForm');

if(deleteScheduleForm) {

    deleteScheduleForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        const dataForm = new FormData(deleteScheduleForm);
        
        await axios.post(`${URL_BASE}/horario/api/del`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response =>{
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
                deleteScheduleModal.hide();
                loadToast(titleSuccess, bodySuccess, success);                        
                loada(); 

            }
        })
        .catch(error => console.log(error))

    });
    


}

function load() {
    divLoad.classList.add("load");
    divLoader.classList.add("loader");
 }
 const stopLoad = ()=>{
    divLoad.classList.remove("load");
    divLoader.classList.remove("loader");
 }
