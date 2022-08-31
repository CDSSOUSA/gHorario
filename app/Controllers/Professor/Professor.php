<?php

namespace App\Controllers\Professor;

use App\Models\ProfessorModel;
use App\Controllers\BaseController;
use App\Models\DisciplinaModel;
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

        $data = [
            'title' => 'Adicionar Professor',
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
                'nCorDestaque' => 'required',
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
                return redirect()->to('/professor');
            }
            return redirect()->to('/teacDisc/list/'.$this->professorModel->getInsertID());
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

        $data = [
            'title' => 'Listar Professores',
            'msgs' => $msgs,
            'erro' => $this->erros,
            'disciplinas' => $this->disciplinaModel->findAll(),
            'teachers' => $this->professorModel->findAll(),

            //'series' => $this->series->getSeries()
            //'erro' => $this->erros
        ];
        //session()->set('dado',$data);
        return view('professor/list', $data);

    }
}
