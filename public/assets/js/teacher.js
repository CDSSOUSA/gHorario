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

        let ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="activeSeries(${element.id})"><i class="far fa-circle nav-icon" aria-hidden="true"></i> Ativar</a>`;

        if (element.status === "A") {
            console.log(element.status)
            ticket = `<a href="#" class="btn btn-dark btn-sm" onclick="activeSeries(${element.id})"><i class="fa fa-check-circle"></i> Desativar</a>`;
        }
        row +=
            `<tr>
                <td>${indice + 1}</td>
                <td>${element.name}º ${element.name} - ${convertShift(element.name)} </td>   
                <td class="discipline">${listTeachDiscs(element.id)}</td>                     
                <td>${ticket}</td>        
            </tr>`;

    });
    return row;
}


// for (let i = 0; i < collection.length; i++) {
//   collection[i].style.backgroundColor = "red";
// }

// const divOpcao = document.querySelectorAll('td.discipline')
// divOpcao.innerHTML = ''

const listTeachDiscs = (id) => {
    //let r = ""
    axios.get(`${URL_BASE}/teacher/listTeacDisc/${id}`)
        .then(response => {
            const datas = response.data;

            // const a = adb(datas);
            // console.log(a);

            datas.forEach(e => {
                // console.log(e.color);
                //var collection = document.getElementsByClassName("discipline");
                console.log(id)
                console.log('aquiii')

                if (e.color != 1) {
                    var collection = document.getElementsByClassName("discipline");
                    collection.innerHTML = '';
                    for (let i = 0; i < collection.length; i++) {
                        collection[i].innerHTML += `
                      <div class="m-2 p-2 font-weight-bold" style="background-color:${e.color}; color:white">
                      <i class="icons fas fa-book"></i> ${e.abbreviation} :: ${e.amount}
                     </div>`;
                    }
                } else {
                    var collection = document.getElementsByClassName("discipline");
                    collection.innerHTML = ''
                }
            }
            );


        }
        )
        .catch(error => console.log(error))
    //return r;
}

function adb(data) {
    let r = "";

    data.forEach((e, indice) => {
        if (e.color) {
            r += `<div class="m-2 p-2 font-weight-bold" style="background-color:${e.color}; color:white">
            <i class="icons fas fa-book"></i> ${e.abbreviation} :: ${e.amount}
        </div>`
            //console.log(r);
        }
    })
    //console.log(r);
    return r;
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
                    location.reload();

                }
            })
            .catch(error => console.log(error))
    });
}