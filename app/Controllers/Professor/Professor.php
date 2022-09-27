<?php

namespace App\Controllers\Professor;

use App\Controllers\BaseController;
use App\Models\DisciplineModel;
use App\Models\TeacherModel;

class Professor extends BaseController
{
    public $erros = '';
    public $professorModel;

    private $disciplinaModel;
    private $teacherModel;

    public function __construct()
    {
        $this->professorModel = new TeacherModel();
        $this->disciplinaModel = new DisciplineModel();
    }

    public function add()
    {
        $msgs = [
            'message' => '',
            'alert' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msgs = $this->messageErro;
        }
        if (session()->has('success')) {
            $msgs = $this->messageSuccess;
        }

        $data = [
            'title' => '<i class="fa fa-user"></i> Cadastrar Professor(a) ::',
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',
                '<li class="breadcrumb-item active"> Cadastrar </li>',
                '<li class="breadcrumb-item">' . anchor('/professor/list', 'Listar') . '</li>',
            ],
            'msgs' => $msgs,
            'erro' => $this->erros,
            'disciplinas' => $this->disciplinaModel->findAll()

            //'series' => $this->series->getSeries()
            //'erro' => $this->erros
        ];
        //session()->set('dado',$data);
        return view('professor/add', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }

        $val = $this->validate(
            [
                'nNome' => 'required|min_length[3]',
                'nNumeroAulas' => 'required',
                'nCorDestaque' => 'required|is_unique[tb_teacher.color]',
                'nDisciplinas' => 'required',
            ],
            [
                'nNome' => [
                    'required' => 'Preenchimento obrigatório!',
                    'min_length' => 'Mínimo permitido 3 caracteres!'
                ],
                'nNumeroAulas' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'nCorDestaque' => [
                    'required' => 'Preenchimento obrigatório!',
                    'is_unique' => 'Cor utilizada por outro (a) professor (a)!',
                ],
                'nDisciplinas' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
            ]
        );


        if (!$val) {
            return redirect()->back()->withInput()->with('erro', $this->validator);
            //return redirect()->to('/admin/blog');
        } else {


            $professor['name'] = mb_strtoupper($this->request->getPost('nNome'));
            $professor['amount'] = $this->request->getPost('nNumeroAulas');
            $professor['color'] = $this->request->getPost('nCorDestaque');
            $professor['disciplines'] = $this->request->getPost('nDisciplinas[]');
            $professor['status'] = 'A';

            if ($this->professorModel->saveProfessor($professor)) {

                $data['msgs'] = [
                    'message' => '<i class="fas fa-exclamation-triangle"></i> Parabéns! Professor adicionado com sucesso!',
                    'alert' => 'success'
                ];
                $data['title'] = 'Cadastrar Professor';
                $data['erro'] = '';
                //$data['series'] = $this->series->getSeries();            

                //return view('professor/add-professor', $data);
                session()->remove('dado');
                session()->set('dado', $data);
                session()->set('success', $data);
                return redirect()->to('/professor');
            }
            session()->set('success', [
                'salutation' => '<h4 class="alert-heading">Parabéns!</h4>',
                'message' => '<p> Operação realizada com sucesso!</p><hr>
                              <p class="mb-0"><i class="fa fa-exclamation-triangle"></i> Defina uma nova cor e a quantidade de horas para cada disciplina!</p>',
                'alert' => 'success'
            ]);
            return redirect()->to('/teacDisc/list/' . $this->professorModel->getInsertID());
        }
    }

    public function list()
    {
        $msgs = [
            'message' => '',
            'alert' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msgs = $this->messageErro;
        }

        $newJs = [
            base_url() . "/assets/js/teacher.js",
        ];
        $js = array_merge($this->javascript, $newJs);

        $data = [
            'title' => '<i class="fa fa-user"></i> Listar Professores :: ',
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',                
                '<li class="breadcrumb-item active"> Listar </li>'
            ],
            'msgs' => $msgs,
            'erro' => $this->erros,
            'disciplinas' => $this->disciplinaModel->findAll(),
            'teachers' => $this->professorModel->findAll(),
            'css' => $this->style,
            'js' => $js,

            //'series' => $this->series->getSeries()
            //'erro' => $this->erros
        ];
        //session()->set('dado',$data);
        return view('teacher/list', $data);
    }
}
