<?php

function toDataBr($data): String
{
    if ($data == null) {
        return '--';
    }
    $data = explode("-", $data);
    return $data[2] . "/" . $data[1] . "/" . $data[0];
}

function toDataMsql($data)
{
    if (!empty($data)) {
        $data = explode("/", $data);
        return $dataAtendimento = $data[2] . "-" . $data[1] . "-" . $data[0];
    }
    return NULL;
}


/**
 * Method diaSemanaExtenso
 *
 * @param int $diaSemana [explicite description]
 *
 * @return string
 */
function diaSemanaExtenso(int $diaSemana): string
{
    $days = [
        "SEG","TER","QUA","QUI","SEX"
    
    ];

    foreach($days as $key => $item){
        if($diaSemana === $key + 2)
        return $item;
    }
    return null;

    // switch ($diaSemana) {
    //     case $diaSemana == 2:
    //         return 'SEG';
    //     case $diaSemana == 3:
    //         return 'TER';
    //     case $diaSemana == 4:
    //         return 'QUA';
    //     case $diaSemana == 5:
    //         return 'QUI';
    //     case $diaSemana == 6:
    //         return 'SEX';
    //     default:
    //         return null;
    // }
}
function translateSchedule(int $position, $shift=null)
{
    $schedule = [
        "M" => [
            "07:00 - 07:45",
            "07:45 - 08:30",
            "08:30 - 09:15",
            "09:15 - 10:00",
            "10:00 - 10:45", 
            "10:45 - 11:30" 
        ],
        "T" => [
            "13:00 - 13:45",
            "13:45 - 14:30",
            "14:30 - 15:15",
            "15:15 - 16:00",
            "16:00 - 16:45", 
            "16:45 - 17:30" 
        ] 
    ];
    //dd($schedule);

    foreach($schedule as $key => $item) {
        foreach($item as $k => $it) {
            if($position === $k + 1 && $key === $shift)
            return $it;
        }       
       
    }
    return null;
   
}
function generationColor()
{
    return '#'.sprintf("%02X%02X%02X", mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
}
function turno($turno): string
{
    if (empty($turno) || $turno !== 'T') {
        return 'MANH??';
    }
    return "TARDE";
}
function convertDiscipline(string $string): string
{
    return mb_substr($string, 0, 3);
}

function describeTeacher(string $nomeCompleto, string $disciplina): string
{
    return word_limiter($nomeCompleto, 1, '') . ' <br> ' . convertDiscipline($disciplina);
}

function abbreviationTeacher(string $nomeCompleto): string
{
    return word_limiter($nomeCompleto, 1, '');
}

function generateButtonRetro(string $adress): string
{
    return anchor($adress, '<i class="icons fas fa-arrow-circle-left"></i> Voltar', ['class' => 'btn btn-outline-warning']);
}
function generateButtonCloseModal(): string
{
    return '<button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>';
}
function generationButtonSave(string $title = null): string
{
    if ($title == null)
        $title = 'Salvar';
    return '<button type="submit" class="btn btn-outline-success"> <i class="fa fa-check" aria-hidden="true"></i> ' . $title . '</button>
    ';
}



/**
 * [Description for convertSituation]
 *
 * @param string $situation
 * 
 * @return string
 * 
 */
function convertSituation(string $situation): string
{
    if ($situation === 'L')
        return 'LIVRE';
    if ($situation === 'O')
        return 'OCUPADO';
    return 'BLOQUEADO';
}

function generateAlertFieldErro(string $field)
{
    if($field === '')
    return;
    return '<span class="alert-close invalid-feedback"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> '.$field.'</span>';

}

function generateButtonClear()
{
    return '<button type="reset" class="btn btn-secondary"><i class="fa fa-minus-circle" aria-hidden="true"></i> Limpar</button>
    ';
}