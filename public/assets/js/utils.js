
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

function marca(caller) {
    var checks = document.querySelectorAll('input[type="checkbox"]');
    for (let i = 0; i < checks.length; i++) {
        checks[i].checked = checks[i] == caller;
    }  
   
        //     checks.addEventListener('click', () => {   
        //     $(":checkbox").each(
        //         function() {
        //             if ($(this).bootstrapSwitch('state')) {
        //                 $(this).bootstrapSwitch('state', false);
        //             } else {
        //                 $(this).bootstrapSwitch('state',true)
        //             }            
        //         }
        //     );
        // }
        ;

}
const URL_BASE = 'http://localhost/gerenciador-horario/public';

const convertStatus = (status) => {
    let _shift = 'INATIVO'
    if (status === 'A')
        _shift = 'ATIVO'
    return _shift;
}

const convertDayWeek = (dia) => {
    let day
    const data = [
        "SEG",
        "TER",
        "QUA",
        "QUI",
        "SEX"
    ]
    data.forEach((item, indice) => {
        if (dia == indice + 2) {
            day = item
        }
    });
    return day;
}

const convertShift = (turno) => {
    let shift = 'TARDE'
    if (turno === 'M')
        shift = 'MANHÃ'
    return shift;
}

const loadToast = (title, body, bg) => {

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

const validateErros = (errors, locale) => {
    let r = document.getElementById(locale).innerHTML = '';
    if (errors) {
        r = document.getElementById(locale).innerHTML = `<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ${errors}!`
    }
    return r;
}
