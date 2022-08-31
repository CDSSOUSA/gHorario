$("input[type=checkbox]").bootstrapSwitch(
    {
        onText: 'SIM',
        offText: "NÃO",
        size: "mini",
    }
    );
    $('#addTeacherDisciplineModal').on('hidden.bs.modal', function (e) {
        document.getElementById('qtdeAulas').value = '';
        document.getElementById('color').value = '';
        const a = document.querySelectorAll('input[type=checkbox]');
        //$("input[type=checkbox]").prop('checked', false);
        a.forEach((element) => {
            //element.style.setProperty("border", "1px solid #dc3545");
            
            console.log(element);
        } )
        // Faça algo, aqui...
    })
    
    const addModal = new bootstrap.Modal(document.getElementById('addTeacherDisciplineModal'));
    const editModal = new bootstrap.Modal(document.getElementById('editTeacherDisciplineModal'));
    
    const URL = 'http://localhost/gerenciador-horario/public';
    
    async function addTeacherDiscipline(id) {   
        document.getElementById('msgAlertError').innerHTML = '';
        document.getElementById('fieldlertError').textContent = '';
        
        const addForm = document.getElementById('addTeacherDisciplineForm');
        
        addModal.show();
        document.getElementById('id').value = id
        console.log(addForm);
        
        if (addForm) {
            addForm.addEventListener("submit", async (e) => {
                e.preventDefault();
                const dataForm = new FormData(addForm);
                await axios.post(`${URL}/teacDisc/create`, dataForm, {
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
                        addForm.reset()
                    } else {
                        document.getElementById('msgAlertError').innerHTML = '';                       
                        addModal.hide();
                        document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                        location.reload();

                    }
                })
                .catch(error => console.log(error))
        })
    }



}
async function editTeacherDiscipline(id) {
    document.getElementById('msgAlertError').innerHTML = '';
    document.getElementById('fieldlertError').textContent = '';
    
    axios.get(URL + '/teacDisc/edit/' + id)
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
        await axios.post(`${URL}/teacDisc/update`, dataForm, {
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
                    //editModal.hide();
                    document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                    location.reload();

                }
            })
            .catch(error => console.log(error))
    })
}

async function delTeacherDiscipline(id) {
    await axios.get(URL + '/teacDisc/delete/' + id)
        .then(response => {
            const data = response.data;
            console.log(data);
            if (data) {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteTeacherDisciplineModal'));
               
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

        await axios.post(`${URL}/teacDisc/del`, dataForm, {
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
                    //editModal.hide();
                    document.getElementById('msgAlertSuccess').innerHTML = response.data.msg
                    location.reload();

                }
            })
            .catch(error => console.log(error))
    })
}


function list(id) {
    const a = axios.get(`${URL}/teacDisc/list/${id}`).then(response => {
        response.data;
    });

    console.log(a);
}



