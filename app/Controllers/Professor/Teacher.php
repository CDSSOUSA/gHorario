<?php

namespace App\Controllers\Professor;

use App\Controllers\BaseController;
use App\Models\DisciplineModel;
use App\Models\TeacherModel;
use Exception;
use App\Models\TeacDiscModel;

class Teacher extends BaseController
{

    public $erros = '';
    public $disciplineModel;
  
    private $teacherModel;
    private $teacDiscModel;

    public function __construct()
    {
        $this->teacherModel = new TeacherModel();
        $this->disciplineModel = new DisciplineModel();
        $this->teacDiscModel = new TeacDiscModel();
    }
    public function create()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }
        $val = $this->validate(
            [
                'name' => 'required|min_length[3]',
                'amount' => 'required',
                'color' => 'required|is_unique[tb_teacher.color]',
                'disciplines' => 'required',
            ],
            [
                'name' => [
                    'required' => 'Preenchimento obrigatório!',
                    'min_length' => 'Mínimo permitido 3 caracteres!'
                ],
                'amount' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'color' => [
                    'required' => 'Preenchimento obrigatório!',
                    'is_unique' => 'Cor utilizada por outro (a) professor (a)!',
                ],
                'disciplines' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
            ]
        );

        if (!$val) {

            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => '<div class="alert alert-danger alert-close alert-dismissible fade show" role="alert">
                            <strong> <i class="fa fa-exclamation-triangle"></i>  Ops! </strong>Erro(s) no preenchimento do formulário! 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>',
                'msgs' => $this->validator->getErrors()
            ];

            return $this->response->setJSON($response);
        }


        $teacher['name'] = mb_strtoupper($this->request->getPost('name'));
        $teacher['amount'] = $this->request->getPost('amount');
        $teacher['color'] = $this->request->getPost('color') == '#000000' ? generationColor() : $this->request->getPost('color') ;
        $teacher['disciplines'] = $this->request->getPost('disciplines[]');
        $teacher['status'] = 'A';
        $teacher['id_year_school'] = session('session_idYearSchool');
        //$data['status'] = 'A';

        // if ($data['description'] > getenv('YEAR.END')) {
        //     return redirect()->back()->withInput()->with('error', 'Ano não permitido!');
        // }

        $save = $this->teacherModel->saveProfessor($teacher);

        if ($save) {
            $response = [
                'status' => 'OK',
                'error' => false,
                'code' => 200,
                'msg' => '<p>Operação realizada com sucesso!</p>',
                //'data' => $this->list()
            ];
            return $this->response->setJSON($response);
        }
    }


    public function list()
    {       
        try {

            $data = $this->teacherModel->findAll();
           

            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
    }

    public function listTeacDisc(int $id)
    {
        $data = $this->teacDiscModel->getTeacherDisciplineByIdTeacher($id);

        return $this->response->setJSON($data);
    }
}
