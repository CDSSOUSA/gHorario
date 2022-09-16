$("input[type=checkbox]").bootstrapSwitch(
    {
        onText: '<i class="fa fa-check"></i>',
        offText: '',
        size: "mini",
        onColor: "success"
    }
);

const checkAll = document.getElementById('checkAll');

checkAll.addEventListener('click', () => {   
    $(":checkbox").each(
        function() {
            if ($(this).bootstrapSwitch('state')) {
                $(this).bootstrapSwitch('state', false);
            } else {
                $(this).bootstrapSwitch('state',true)
            }            
        }
    );
});


var divLoad = document.querySelector('#load');
var divLoader = document.querySelector('#loader');
var titleSuccess = '<strong class="me-auto">Parabéns!</strong>';
var bodySuccess = ' Operação realizada com sucesso';
var success = 'success';
//const URL_BASE = 'http://localhost/gerenciador-horario/public';

$('#addTeacherDisciplineModal').on('hidden.bs.modal', function (e) {
    document.getElementById('qtdeAulas').value = '';
    document.getElementById('color').value = '';
    const a = document.querySelectorAll('input[type=checkbox]');
    //$("input[type=checkbox]").prop('checked', false);
    a.forEach((element) => {
        //element.style.setProperty("border", "1px solid #dc3545");
        //$(element.currentTarget).remove();
        console.log(element);
    })
    // Faça algo, aqui...
})

//const editModal = new bootstrap.Modal(document.getElementById('editTeacherDisciplineModal'));


async function addTeacherDiscipline(id) {
    const addModal = new bootstrap.Modal(document.getElementById('addTeacherDisciplineModal'));
    document.getElementById('msgAlertError').innerHTML = '';
    document.getElementById('fieldlertError').textContent = '';

    const addForm = document.getElementById('addTeacherDisciplineForm');

    addModal.show();
    document.getElementById('id').value = id
    console.log(addForm);

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
                        document.getElementById('msgAlertError').innerHTML = response.data.msg
                        document.getElementById("msgAlertSuccess").innerHTML = "";
                        //loadToast('oi','oila','danger');
                        addForm.reset()
                        

                    } else {
                        document.getElementById('msgAlertError').innerHTML = '';
                        addModal.hide();
                        //document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                       
                        loadToast(titleSuccess, bodySuccess, success);                        
                        loada(); 
                        location.reload();

                    }
                })
                .catch(error => console.log(error))
        })
    }



}
// async function editTeacherDiscipline(id) {
//     document.getElementById('msgAlertError').innerHTML = '';
//     document.getElementById('fieldlertError').textContent = '';

//     axios.get(URL_BASE + '/teacDisc/edit/' + id)
//         .then(response => {
//             const data = response.data;
//             console.log(data);
//             if (data) {
//                 editModal.show();
//                 document.getElementById('idEdit').value = data[0].id
//                 document.getElementById('nameEdit').value = data[0].name
//                 document.getElementById('id_discipline').value = data[0].description
//                 document.getElementById('numeroAulas').value = data[0].amount
//                 document.getElementById('corDestaque').value = data[0].color
//             }
//         })
//         .catch(error => console.log(error))
// }

// const editForm = document.getElementById('editTeacherDiscipline');
// console.log(editForm);

// if (editForm) {

//     editForm.addEventListener("submit", async (e) => {
//         e.preventDefault();
//         const dataForm = new FormData(editForm);
//         await axios.post(`${URL_BASE}/teacDisc/update`, dataForm, {
//             headers: {
//                 "Content-Type": "application/json"
//             }
//         })
//             .then(response => {
//                 console.log(response.data.id_teacher);
//                 if (response.data.error) {
//                     document.getElementById('msgAlertError').innerHTML = response.data.msg
//                     document.getElementById('fieldlertError').textContent = 'Preenchimento obrigatório!'
//                     document.getElementById("msgAlertSuccess").innerHTML = "";
//                 } else {

//                     document.getElementById('msgAlertError').innerHTML = '';
//                     document.getElementById('fieldlertError').textContent = '';
//                     //document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
//                     //location.reload();
//                     editModal.hide();
                    
//                     loadToast(titleSuccess, bodySuccess, success);                        
//                     loada(); 
//                     location.reload();

//                 }
//             })
//             .catch(error => console.log(error))
//     })
// }

const deleteModal = new bootstrap.Modal(document.getElementById('deleteTeacherDisciplineModal'));
async function delTeacherDiscipline(id) {
    await axios.get(URL_BASE + '/teacDisc/delete/' + id)
        .then(response => {
            const data = response.data;
            console.log(data);
            if (data) {

                deleteModal.show();
                document.getElementById('idDelete').value = data[0].id

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
                    //document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                    //location.reload();
                    loadToast(titleSuccess, bodySuccess, success);                        
                    loada(); 
                    location.reload();

                }
            })
            .catch(error => console.log(error))
    })
}


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
//         location.reload();
//     });
// }

function loada() {
    divLoad.classList.add("loada");
    divLoader.classList.add("loader");
    $('.toast').append(`
    <div class="text-center bg-success p-1"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Atualizando</div>
  `);
 }

