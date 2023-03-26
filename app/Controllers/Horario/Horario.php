<?php

namespace App\Controllers\Horario;

use App\Models\SerieModel;
use App\Models\HorarioModel;
use App\Controllers\BaseController;
use App\Controllers\TeacDisc;
use App\Models\AllocationModel;
use App\Models\AlocacaoModel;
use App\Models\ProfessorModel;
use App\Models\SchoolScheduleModel;
use App\Models\SeriesModel;
use App\Models\TeacDiscModel;

class Horario extends BaseController
{
    public $horarioSegunda;
    public $series;
    public $alocacaoProfessor;
    public $horario;
    public $professor;
    public $erros = '';

    private $teacherDiscipline;

    public function __construct()
    {
        $this->horarioSegunda = new HorarioModel();
        $this->series = new SeriesModel();
        //$this->alocacaoProfessor = new AlocacaoModel();
        $this->alocacaoProfessor = new AllocationModel();
        $this->professor = new ProfessorModel();
        $this->horario = new SchoolScheduleModel();
        $this->teacherDiscipline = new TeacDiscModel();

        helper('url');
        helper('text');
    }

    /**
     * [Description for index]
     *
     * @return string
     * 
     */
    public function index(string $shift = null): string
    {
        if ($shift === null || $shift !== 'T') {
            $shift = 'M';
        } else {
            $shift = 'T';
        }

        $msg = [
            'message' => '',
            'alert' => ''
        ];
        //d($this->style);
        $newJs = [
            base_url() . "/assets/js/school-schedule.js",
        ];
        $js = array_merge($this->javascript, $newJs);
        //d($js);
        $data = array(
            'title' => '<i class="fa fa-th"></i> Quadro de  Horário :: ' . turno($shift). ' - '.$this->yearSchoolActive->description,
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',
                '<li class="breadcrumb-item active"> Quadro Horário - '.turno($shift).'</li>',                
                '<li class="breadcrumb-item">'. anchor($shift == 'T' ? '/':'/horario/shift/T','Quadro Horário - '.turno($shift == 'T' ? 'M':'T')).'</li>',                
            ],
            'msgs' => $msg,
            'series' => $this->series->getSeries($shift),
            'schoolSchedule' => $this->horario,
            'allocation' => $this->alocacaoProfessor,
            //'erro' => $this->erros,
            'teacherDiscipline' => $this->teacherDiscipline,
            'shift' => $shift,
            'css' => $this->style,
            'js' => $js,
        );

        return view('schedule/horario', $data);
    }
  
    public function addProfissionalHorario(int $id_serie, int $dia_semana, int $posicao, string $shift): string
    {
        $msg = [
            'message' => '',
            'alert' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msg = $this->messageErro;
        }

        $data = array(
            'title' => 'Adicionar Profissional ao Horário',
            'msgs' => $msg,
            'diaSemana' => $dia_semana,
            'idSerie' => $this->series->find($id_serie),
            'posicao' => $posicao,
            'professores' => $this->alocacaoProfessor->getAllocationByDayWeekA($id_serie, $dia_semana, $posicao, $shift),
            'msgs' => $msg,
            'erro' => $this->erros,
            'shift' => $shift

            //'series' => $this->series->getSeries()
            //'erro' => $this->erros
        );
        return view('horadrio/add-profissional-horario', $data);
    }

    public function add()
    {

        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }

        $val = $this->validate(
            [
                'nIdAlocacao' => 'required',
            ],
            [
                'nIdAlocacao' => [
                    'required' => 'Preenchimento Obrigatório!',
                ],
            ]
        );

        if (!$val) {
            return redirect()->back()->withInput()->with('erro', $this->validator);
        }


        $idAlocacao = $this->request->getPost('nProfessor');
        //$dado = $this->alocacaoProfessor->find($idAlocacao);
        $horario['id_allocation'] = $this->request->getPost('nIdAlocacao');
        //$horario['nome'] = word_limiter($this->professor->getNomeProfessor($dado['id_professor'])->nome, 1, '');
        $horario['dayWeek'] = $this->request->getPost('ndiaSemana');
        $horario['position'] = $this->request->getPost('nPosicao');
        $horario['id_series'] = $this->request->getPost('nSerie');
        //$horario['id_ano_letivo'] = 1;
        $horario['status'] = 'A';

        /* BUSCAR DADOS DA ALOCAÇÃO PARA MODIFICAR */
        // $dadoAlocacao = $this->alocacaoProfessor->find($this->request->getPost('nIdAlocacao'));
        // $alocacao['id'] = $dadoAlocacao['id'];
        // $alocacao['id_professor'] = $dadoAlocacao['id_professor'];        
        // $alocacao['dia_semana'] = $dadoAlocacao['dia_semana'];
        // $alocacao['posicao_aula'] = $dadoAlocacao['posicao_aula'];        
        // $alocacao['status'] = $dadoAlocacao['status'];
        // $alocacao['situacao'] = 'O';

        if ($this->horario->save($horario)) {
            $allocation = $horario['id_allocation'];
            $this->alocacaoProfessor->set('situation', 'O')
                ->where('id', $allocation)
                ->update();

            $data['msgs'] = $this->messageSuccess;
            $data['title'] = 'Cadastrar Horário';
            $data['erro'] = '';
            $data['series'] = $this->series->findAll();
            $data['schoolSchedule'] = $this->horario;
            $data['allocation'] =  $this->alocacaoProfessor;

            return view('horario/horario', $data);
        }
    }
}
