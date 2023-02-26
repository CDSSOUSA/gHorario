var titleSuccess = '<strong class="me-auto">Parabéns!</strong>';
var bodySuccess = ' Operação realizada com sucesso';
var success = 'success';
const checkAll = document.getElementById('checkAll');

checkAll.addEventListener('click', () => {
    $(".checkbox").each(
        function () {
            if ($(this).bootstrapSwitch('state')) {
                $(this).bootstrapSwitch('state', false);
                // checkAll.style.backgroundColor = '#FFF'
                // checkAll.style.color = '#000'
            } else {
                $(this).bootstrapSwitch('state', true)
                // checkAll.style.backgroundColor = 'green'
                // checkAll.style.color = '#FFF'
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
const convertStatusRotulo = (status) => {
    let _shift = 'Ativar'
    if (status === 'A')
        _shift = 'Desativar'
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

function translateSchedule(position, shift) {
    let textSchedule
    var schedule = [];
    schedule['M'] = [
        "07:00 - 07:45",
        "07:45 - 08:30",
        "08:30 - 09:15",
        "09:15 - 10:00",
        "10:00 - 10:45",
        "10:45 - 11:30"
    ];
    schedule['T'] = [
        "13:00 - 13:45",
        "13:45 - 14:30",
        "14:30 - 15:15",
        "15:15 - 16:00",
        "16:00 - 16:45",
        "16:45 - 17:30"
    ];

    //console.log(schedule)
    schedule[shift].forEach((item, ind) => {
        if (position == ind + 1) {
            //console.log(item)
             textSchedule = item
        }
    })
    return textSchedule
    

}

const convertShift = (turno) => {
    let shift = 'TARDE'
    if (turno === 'M')
        shift = 'MANHÃ'
    return shift;
}

const convertShiftAbbreviation = (turno) => {
    let shift = 'Tar'
    if (turno === 'M')
        shift = 'Man'
    return shift;
}

const convertSituation = (situation) => {
    if (situation === 'L')
        return 'LIVRE';
    if (situation === 'O')
        return 'OCUPADO';
    return 'BLOQUEADO';
}

const loadToast = (title, body, bg) => {

    $(document).Toasts('create', {
        title: title,
        icon: 'fas fa-exclamation-triangle',
        class: `bg-${bg} m-1 width-500 toast z-index-1000`,
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

const writeZero = (values) => {
    let a = values.length
    if(a <= 1){
        return `0${values}`;
    }
   return values;

}