<?php

namespace App\Controllers\TeacDisc;

use App\Controllers\BaseController;
use App\Models\DisciplineModel;
use App\Models\TeacDiscModel;
use App\Models\TeacherModel;
use App\Models\AllocationModel;

class TeacDisc extends BaseController
{
    private $teacDiscModel;
    public $erros = '';
    private $teacherModel;
    private $disciplineModel;
    private $allocation;
    public function __construct()
    {
        $this->teacDiscModel = new TeacDiscModel();
        $this->teacherModel = new TeacherModel();
        $this->disciplineModel = new DisciplineModel();
        $this->allocation = new AllocationModel();
    }
    public function list(int $idTeacher)
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
            $msgs = session('success');
        }

        $data = [
            'title' => '<i class="fa fa-user"></i> Editar Professor/Disciplina :: ',
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',
                '<li class="breadcrumb-item">' . anchor('/professor', 'Cadastrar') . '</li>',
                '<li class="breadcrumb-item">' . anchor('/professor/list', 'Listar') . '</li>',
                '<li class="breadcrumb-item active"> Editar Professor/Disciplina </li>',
                '<li class="breadcrumb-item">' . anchor('/alocacao/add/'.$idTeacher, 'Alocacão') . '</li>',
            ],
            'msgs' => $msgs,
            'erro' => $this->erros,
            'teacDisc' => $this->teacDiscModel->getTeacherDisciplineByIdTeacher($idTeacher),
            'dataTeacher' => $this->teacherModel->find($idTeacher),
            'disciplines' => $this->disciplineModel,

            //'series' => $this->series->getSeries()
            //'erro' => $this->erros
        ];
        //session()->set('dado',$data);
        return view('teacDisc/list', $data);
    }
    public function edit(int $id)
    {

        $data = $this->teacDiscModel->getTeacherDisciplineById($id);
        //dd($data);
        return $this->response->setJSON($data);
    }
    public function create()
    {

        $msgs = [
            'message' => '',
            'alert' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msgs = $this->messageErro;
        }

        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }

        $val = $this->validate(
            [
                'nNumeroAulas' => 'required',
                'nCorDestaque' => 'required',
                'nDisciplinas' => 'required',

            ],
            [
                'nNumeroAulas' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'nCorDestaque' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
            ]
        );


        if (!$val) {
            //return redirect()->back()->withInput()->with('erro', $this->validator);
            $response = [
                'pre' => $this->validator,
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Ops!</strong> Todos os campos são de preenchimento obrigátorio!
  <button type="button" class="close" data-bs-dismiss="alert" aria-bs-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
               
              </div>'
            ];

            return $this->response->setJSON($response);
            //return redirect()->to('/admin/blog');
        } else {
           

            $teacher['color'] = $this->request->getPost('nCorDestaque');
            $teacher['amount']= $this->request->getPost('nNumeroAulas');
            $teacher['id_teacher'] = $this->request->getPost('id_teacher');
            $teacher['disciplines'] = $this->request->getPost('nDisciplinas[]');
            $teacher['status'] = 'A';

           

            $save = $this->teacDiscModel->saveTeacherDiscipline($teacher);              

            if ($save) {
                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Operação realizada com sucesso!</p>'
                ];
                return $this->response->setJSON($response);
            }

            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => 'Erro, não foi possível realizar a operação!'
            ];
            return $this->response->setJSON($response);
        }
    }
    public function delete(int $id)
    {

        $data = $this->teacDiscModel->getTeacherDisciplineById($id);
        //dd($data);
        return $this->response->setJSON($data);
    }

    public function _edit(int $id)
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
            'title' => 'Editar Professor/Disciplina',
            'msgs' => $msgs,
            'erro' => $this->erros,
            'teacDisc' => $this->teacDiscModel->find($id),
            'nameTeacher' => $this->teacherModel->find($this->teacDiscModel->find($id)->id_teacher)['name'],
            'discipline' => $this->disciplineModel->find($this->teacDiscModel->find($id)->id_discipline)['description']

            //'series' => $this->series->getSeries()
            //'erro' => $this->erros
        ];
        //session()->set('dado',$data);
        return view('teacDisc/edit', $data);
    }

    public function del()
    {
        $id = $this->request->getPost('id');

        $delete = $this->teacDiscModel->where('id', $id)
            ->delete();

        if ($delete) {
            $response = [
                'status' => 'OK',
                'error' => false,
                'code' => 200,
                'msg' => '<p>Operação realizada com sucesso!</p>'
            ];
            return $this->response->setJSON($response);
        }
        
        $response = [
            'status' => 'ERROR',
            'error' => true,
            'code' => 400,
            'msg' => 'Erro, não foi possível realizar a operação!'
        ];
        return $this->response->setJSON($response);
    }

    public function update()
    {

        $msgs = [
            'message' => '',
            'alert' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msgs = $this->messageErro;
        }

        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }

        $val = $this->validate(
            [
                'nNumeroAulas' => 'required',
                'nCorDestaque' => 'required',

            ],
            [
                'nNumeroAulas' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'nCorDestaque' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
            ]
        );


        if (!$val) {
            //return redirect()->back()->withInput()->with('erro', $this->validator);
            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Ops!</strong> Erro(s) no preenchimento do formulário! 
  <button type="button" class="close" data-bs-dismiss="alert" aria-bs-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
               
              </div>'
            ];

            return $this->response->setJSON($response);
            //return redirect()->to('/admin/blog');
        } else {

            $color = $this->request->getPost('nCorDestaque');
            $amount = $this->request->getPost('nNumeroAulas');
            $idTeacher = $this->request->getPost('id_teacher');
            $id = $this->request->getPost('id');

            $update = $this->teacDiscModel->set(['color' => $color, 'amount' => $amount])
                ->where('id', $id)
                ->update();

            if ($update) {
                $totalAllocationOcupation = $this->allocation->getCountByIdTeacDiscOcupation($id);
                
                if($amount > $totalAllocationOcupation) {
                
                    $this->allocation->set('situation', 'L')
                    ->where('id_teacher_discipline', $id)
                    ->where('situation', 'B')
                    ->update();                        
                }

                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Operação realizada com sucesso!</p>'
                ];
                return $this->response->setJSON($response);
            }

            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => 'Erro, não foi possível realizar a operação!'
            ];
            return $this->response->setJSON($response);
        }
    }
    public function _update()
    {
        $msgs = [
            'message' => '',
            'alert' => ''
        ];
        if (session()->has('erro')) {
            $this->erros = session('erro');
            $msgs = $this->messageErro;
        }

        if ($this->request->getMethod() !== 'put') {
            return redirect()->to('/admin/blog');
        }

        $val = $this->validate(
            [
                'nNumeroAulas' => 'required',
                'nCorDestaque' => 'required',

            ],
            [
                'nNumeroAulas' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'nCorDestaque' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
            ]
        );


        if (!$val) {
            return redirect()->back()->withInput()->with('erro', $this->validator);
            //return redirect()->to('/admin/blog');
        } else {

            $color = $this->request->getPost('nCorDestaque');
            $amount = $this->request->getPost('nNumeroAulas');
            $idTeacher = $this->request->getPost('id_teacher');
            $id = $this->request->getPost('id');

            $this->teacDiscModel->set(['color' => $color, 'amount' => $amount])
                ->where('id', $id)
                ->update();
        }
        $data = [
            'title' => 'Editar Professor/Disciplina',
            'msgs' => $msgs,
            'erro' => $this->erros,
            'teacDisc' => $this->teacDiscModel->getTeacherDisciplineByIdTeacher($idTeacher),
            'nameTeacher' => $this->teacherModel->find($idTeacher)['name']

            //'series' => $this->series->getSeries()
            //'erro' => $this->erros
        ];
        //session()->set('dado',$data);
        return view('teacDisc/list', $data);
    }
}
