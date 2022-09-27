// var divLoad = document.querySelector('#load');
// var divLoader = document.querySelector('#loader');
// var titleSuccess = '<strong class="me-auto">Parabéns!</strong>';
// var bodySuccess = ' Operação realizada com sucesso';
// var success = 'success';



listSchedule();

async function listSchedule() {
    await axios.get(`${URL_BASE}/horario/api/list`)
        .then(response => {
            const data = response.data;
            console.log(data);
            document.querySelector("#tb_schedule > tbody").innerHTML = `${loadDataSchedule(data)}`;
            //document.querySelector("#tb_schedule > tbody").innerHTML = `${loadDataSchedule(data)}`;
            //loadDataTable(data)
        }
        )
        .catch(error => console.log(error))
}

function loadDataSchedule(data) {

    let row = "";
    // let dayShow = '';
    // let rowColor = '';
    for (let dw = 2; dw < 7; dw++) {
        for (let ps = 1; ps < 7; ps++) {   

            let dayShow = ps === 1 ? convertDayWeek(dw) : '';           
            let rowColor = dw % 2 === 0 ? 'table-secondary' : 'table-success'

            row += `<tr class="${rowColor}"><th scope="row">${dayShow}</th>
            <th>${ps}ª</th>`      
            data.forEach((elem,indice) => {
                row += `<td id="row${ps}${dw}${elem.id}" class="text-left">${listDPS(elem.id, dw, ps, 'M')}</td>`
            })
            row += `</tr>`
               
            
        }
    }

    


    // data.forEach((element, indice) => {
    //     //console.log(data)

    //     let ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="activeSeries(${element.id})"><i class="far fa-circle nav-icon" aria-hidden="true"></i> Ativar</a>`;

    //     if (element.status === "A") {
    //         console.log(element.status)
    //         ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="activeSeries(${element.id})"><i class="fa fa-check-circle"></i> Desativar</a>`;
    //     }
    //     row +=
    //         `<tr>
    //             <td>${indice + 1}</td>
    //             <td>${element.description}º ${element.classification} - ${convertShift(element.shift)} </td>
    //             <td>${convertStatus(element.status)}</td>           
    //             <td>${ticket}</td>        
    //         </tr>`;

    // });
    return row;
}

function listDPS(idSerie, day,position,shift) {
    axios.get(`${URL_BASE}/horario/api/listDPS/${idSerie}/${day}/${position}/${shift}`)
    .then(response => {

      if(response.data == 'vago') {
            document.getElementById(`row${position}${day}${idSerie}`).innerHTML = `
            
            <div class="d-flex m-1 p-2 w-120" style="background-color: transparent; border: 1px solid #9a9a9c; color:black; border-radius: 5px;" data-toggle="tooltip" data-placement="top" title="Aguardando alocação!">
            <div>
                <img src="${URL_BASE}/assets/img/discipline-vague.png" width="28px" class="me-3 border-radius-lg m-2" alt="spotify">
            </div>
            <div class="my-auto">
                <h6 class="mb-0 text-sm font-weight-bold"> VAGO</h6>
            </div>
        </div>`
        } else if(response.data != 'livre') {
            console.log(response.data);
            document.getElementById(`row${position}${day}${idSerie}`).innerHTML = `
            <a href="#" onclick = "deleteSchedule(${response.data.id})" data-toggle="modal" data-placement="top" title="Clique para remover!">
            <div class="d-flex m-1 p-2 w-120" style="background-color: ${response.data.color}; color:white; border-radius: 5px;">
            <div>
                <img src="${URL_BASE}/assets/img/${response.data.icone}" width="28px" class="me-3 border-radius-lg m-2" alt="spotify">
            </div>
            <div class="my-auto">
                <h6 class="mb-0 font-weight-bold font-size-11"> ${response.data.name}</h6>
                <span class="mb-0 font-weight-bold text-sm">${response.data.abbreviation}</span>
            </div>
        </div></a>`
            //loadDisc(response.data)
        }  else {
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

// Adicionar horario
const addScheduleModal = new bootstrap.Modal(document.getElementById('addScheduleModal'));
async function addSchedule(idSerie, position, dayWeek, shift) {
    document.getElementById('msgAlertError').innerHTML = ''
    document.getElementById('fieldlertError').textContent = ''

    addScheduleModal.show();
    document.getElementById('idSerie').value = idSerie
    document.getElementById('position').value = position
    document.getElementById('dayWeek').value = dayWeek
    document.getElementById('shift').value = shift
    document.getElementById('shiftFake').innerText = convertShift(shift)
    document.getElementById('dayWeekFake').innerText = convertDayWeek(dayWeek)
    document.getElementById('positionFake').innerText = `${position}ª`
    const divOpcao = document.getElementById('divOpcao')
    divOpcao.innerHTML = ''

    // await axios.get(`${URL_BASE}/series/show/${idSerie}`)
    //     .then(response => {
    //         console.log(response.data)
    //         document.getElementById('idSerieFake').innerText = `${response.data[0].description}º ${response.data[0].classification}`
    //     })
    //     .catch(error => console.log(error))

    getSeries(idSerie, 'idSerieFake');

    await axios.get(`${URL_BASE}/horario/api/getAllocation/${idSerie}/${dayWeek}/${position}/${shift}`)
        .then(response => {
            const data = response.data;
            data.forEach(element => {
                divOpcao.innerHTML += `                     
                <div class="form-check-inline radio-toolbar text-white m-1 p-1 w-120" style="background-color:${element.color}; border-radius: 5px; margin: 5px;">
                    <input class="form-check-input" type="radio" id="gridCheck1${element.id}" name= "nIdAlocacao" value="${element.id}"/>
                    <label class="form-check-label" for="gridCheck1${element.id}">
                        <div class="d-flex">
                                    <div>
                                        <img src="${URL_BASE}/assets/img/${element.icone}" width="28px" class="discImagem me-3 border-radius-lg p-1" alt="spotify">
                                    </div>
                                    <div class="my-auto">
                                        <h6 class="mb-0 font-weight-bold font-size-11">${element.name.split(" ", 1)}</h6>          
                                        <span class="mb-0 font-weight-bold font-size-11">${element.abbreviation}</span>                         
                                    </div>
                        </div>                       
                    </label>
                </div>`
            });
        })
        .catch(error => console.log(error))
}

const addScheduleForm = document.getElementById('addScheduleForm');
console.log(addScheduleForm);

if (addScheduleForm) {
    addScheduleForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        //load();
        const dataForm = new FormData(addScheduleForm);
        await axios.post(`${URL_BASE}/horario/api/create`, dataForm, {
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                if (response.data.error) {
                    //stopLoad();
                    console.log('errro')
                    document.getElementById('msgAlertError').innerHTML = response.data.msg
                    document.getElementById('fieldlertError').textContent = 'Escolha obrigatória!'

                } else {
                    // load();
                    // //console.log(response.data)
                    addScheduleModal.hide();
                    loadToast(titleSuccess, bodySuccess, success);
                    //loada();
                    //location.reload();
                    listSchedule();
                }
            })
            .catch(error => console.log(error))
    })
}

// End adicionar horario


const deleteScheduleModal = new bootstrap.Modal(document.getElementById('deleteScheduleModal'));

async function deleteSchedule(id) {
    await axios.get(`${URL_BASE}/horario/api/delete/${id}`)
        .then(response => {
            const data = response.data;
            console.log(data);
            if (data) {
                deleteScheduleModal.show();
                document.getElementById('idDelete').value = data.id
                document.getElementById('disciplineDel').innerHTML = `${data.name.split(" ", 1)} - <span>${data.abbreviation}</span> - <span id="idSerieDel">${getSeries(data.id_series, 'idSerieDel')}</span>`
                    ;
                document.getElementById('positonDel').innerText = `${data.position} ª AULA - `
                document.getElementById('dayWeekDel').innerText = `${convertDayWeek(data.dayWeek)} - `
                document.getElementById('shiftDel').innerText = convertShift(data.shift)
                //document.getElementById('nameDel').innerText = data.name.split(" ", 1)
                document.getElementById('color').style.backgroundColor = data.color
                document.getElementById('image-disc').innerHTML = ` <img src="${URL_BASE}/assets/img/${data.icone}" width="28px" class="me-3 border-radius-lg m-2" alt="spotify">`
            }
        })
        .catch(error => console.log(error))

}

const deleteScheduleForm = document.getElementById('deleteScheduleForm');

if (deleteScheduleForm) {

    deleteScheduleForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dataForm = new FormData(deleteScheduleForm);

        await axios.post(`${URL_BASE}/horario/api/del`, dataForm, {
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
                    deleteScheduleModal.hide();
                    loadToast(titleSuccess, bodySuccess, success);
                    //loada();
                    //location.reload();
                    listSchedule();

                }
            })
            .catch(error => console.log(error))

    });



}

async function getSeries(id, locale) {

    await axios.get(`${URL_BASE}/series/show/${id}`)
        .then(response => {
            console.log(response.data)
            document.getElementById(locale).innerText = `${response.data[0].description}º ${response.data[0].classification}`
        })
        .catch(error => console.log(error))
}

// function load() {
//     divLoad.classList.add("loada");
//     divLoader.classList.add("loader");
//     $('.toast').append(`
//     <div class="text-center bg-success p-1"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
//     Atualizando</div>
//   `);
// }
// const stopLoad = () => {
//     divLoad.classList.remove("loada");
//     divLoader.classList.remove("loader");
// }

