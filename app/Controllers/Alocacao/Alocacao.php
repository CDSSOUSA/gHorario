<?php

namespace App\Controllers\Alocacao;

use App\Models\SerieModel;
use App\Models\ProfessorModel;
use App\Models\AlocacaoModel;
use App\Models\ProfessorDisciplinaModel;
use App\Controllers\BaseController;
use App\Controllers\TeacDisc\TeacDisc;
use App\Models\AllocationModel;
use App\Models\SchoolScheduleModel;
use App\Models\SeriesModel;
use App\Models\TeacDiscModel;
use App\Models\TeacherModel;

class Alocacao extends BaseController
{
    public $erros = '';
    public $professor;
    public $series;
    public $alocacao;
    public $professorDisciplina;
    private $teacDiscModel;

    public function __construct()
    {
        $this->professor = new TeacherModel();
        $this->series = new SeriesModel();
        $this->alocacao = new AllocationModel();
        $this->professorDisciplina = new TeacDiscModel();
        $this->teacDiscModel = new TeacDiscModel();
        $this->schedule = new SchoolScheduleModel();
    }

    public function index()
    {
        $msgs = [
            'message' => '',
            'alert' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msgs = $this->messageErro;
        }
        $data = array(
            'title' => 'Alocar Professor',
            'msgs' => $msgs,
            'erro' => $this->erros,
            'professores' => $this->professor->orderBy('nome')->findAll(),
            'professoresDisciplinas' => $this->professorDisciplina->getTeacherDiscipline()
        );
        return view('alocacao/list-professor-alocacao', $data);
    }

    public function add($idTeacher)
    {
        $msgs = [
            'message' => '',
            'alert' => ''
        ];

        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msgs = $this->messageErro;
        }

        if (session()->get('success')) {
            $msgs = $this->messageSuccess;
        }
        if (session()->get('error')) {
            $msgs = [
                'message' => '<i class="bi bi-exclamation-octagon me-1"></i> Ops! Disponibilidade(s) já foi(ram) alocada(s)!',
                'alert' => 'danger'
            ];
        }
        session()->remove('erro');
        session()->remove('error');
        session()->remove('success');

        $data = array(
            'title' => 'Alocar Professor :: ',
            'msgs' => $msgs,
            'erro' => $this->erros,
            'professor' => $this->professor->find($idTeacher),
            'series' => $this->series->getSeries(),
            //'professoresDisciplinas' => $this->professorDisciplina->getAllProfessorDisciplina(),
            'alocacao' => $this->alocacao->getAllAlocacaoProfessor($idTeacher),
            'teacDisc' => $this->teacDiscModel->getTeacherDisciplineByIdTeacher($idTeacher),
            'scheduleModel' => $this->schedule

        );
        return view('alocacao/add', $data);
    }

    /*public function add_etp02($id)
    {

        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }

        $val = $this->validate(
            [
                'nIdProfessor' => 'required',
            ],
            [
                'nIdProfessor' => [
                    'required' => 'Preenchimento Obrigatório!',

                ],

            ]
        );

        if (!$val) {
            return redirect()->back()->withInput()->with('erro', $this->validator);
            //return redirect()->to('/admin/blog');
        } else {


            $data['msgs'] = [
                'message' => '',
                'alert' => ''
            ];
            $data['title'] = 'Alocar Professor';
            $data['erro'] = '';
            $data['professor'] = $this->professor->find($this->request->getPost('nIdProfessor'));
            $data['series'] = $this->series->getSeries();
            $data['alocacao'] = $this->alocacao->getAllAlocacaoProfessor($this->request->getPost('nIdProfessor'));
            
            return view('alocacao/add-alocacao-etp02/'.$id, $data);
        }
    }*/

    public function create()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }
        $val = $this->validate(
            [
                'nIdProfessor' => 'required',
                'nDisciplines' => 'required',
                'nPosition' => 'required',
                'nDayWeek' => 'required',
            ],
            [
                'nIdProfessor' => [
                    'required' => 'Preenchimento Obrigatório!',
                ],
                'nDisciplines' => [
                    'required' => 'Preenchimento Obrigatório!',
                ],
                'nPosition' => [
                    'required' => 'Preenchimento Obrigatório!',
                ],
                'nDayWeek' => [
                    'required' => 'Preenchimento Obrigatório!',
                ]

            ]
        );
        if (!$val) {
            return redirect()->back()->withInput()->with('erro', $this->validator);
            //return redirect()->to('/admin/blog');
        }


        $idTeacher = $this->request->getPost('nIdProfessor');
        $data['dayWeek'] = $this->request->getPost('nDayWeek[]');
        $data['disciplines'] = $this->request->getPost('nDisciplines[]');
        $data['position'] = $this->request->getPost('nPosition[]');
       

        $save = $this->alocacao->saveAllocation($data);

        if($save){

            session()->set(['success' => true]);

            return redirect()->to('alocacao/add/' . $idTeacher);
            
        } 
        session()->set(['error' => $this->messageErro]);

        //return redirect()->back()->withInput()->with('error', $this->messageErro);
            

        return redirect()->to('alocacao/add/' . $idTeacher);
        

    }

    public function delete()
    {
        $idAlocacao = $this->request->getPost('id');

        $dataProfessor = $this->alocacao->getTeacherByIdAllocation($idAlocacao);

        if ($dataProfessor) {

            //$data['title'] = 'Alocar Professor';
            //$data['erro'] = '';
            $data = $this->professor->find($dataProfessor[0]->id_teacher)->id;
            //$data['series'] = $this->series->getSeries();
            //$data['alocacao'] = $this->alocacao->getAllAlocacaoProfessor($dataProfessor['id']);

            if ($this->alocacao->delete($idAlocacao)) {
                //$data['msgs'] = $this->messageSuccess;
                //$data['professores'] = $this->professor->orderBy('nome')->findAll();             

                session()->set(['success' => true]);

                return redirect()->to('alocacao/add/' . $data);
            }

            session()->set(['success' => false]);
            return $this->add($dataProfessor['id']);
            //return redirect()->to("alocacao/add_etp02");

            //return $parser->render('alocacao/add-alocacao-etp02');
        }
        //return redirect()->to('/alocacao');
        //return view('alocacao/add/'.$dataProfessor['id_professor'], $data);
    }
}
