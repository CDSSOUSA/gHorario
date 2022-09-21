<?php

namespace App\Controllers\Allocation;

use App\Controllers\BaseController;
use App\Models\AllocationModel;
use Exception;

class Allocation extends BaseController
{

    //public $erros = '';
    // public $professor;
    // public $series;
    public $allocationModel;
    // public $professorDisciplina;
    // private $teacDiscModel;

    public function __construct()
    {
        //$this->professor = new TeacherModel();
        //$this->series = new SeriesModel();
        $this->allocationModel = new AllocationModel();
        //$this->professorDisciplina = new TeacDiscModel();
        //$this->teacDiscModel = new TeacDiscModel();
        // $this->schedule = new SchoolScheduleModel();
    }
    public function create()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }
        $val = $this->validate(
            [
                'id_teacher' => 'required',
                'nDisciplines' => 'required',
                'nPosition' => 'required',
                'nDayWeek' => 'required',
                'nShift' => 'required',
            ],
            [
                'id_teacher' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'nPosition' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'nDayWeek' => [
                    'required' => 'Preenchimento obrigatório!',

                ],
                'nShift' => [
                    'required' => 'Preenchimento obrigatório!',

                ],
                'nDisciplines' => [
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

        $idTeacher = $this->request->getPost('id_teacher');
        $data['dayWeek'] = $this->request->getPost('nDayWeek[]');
        $data['disciplines'] = $this->request->getPost('nDisciplines[]');
        $data['position'] = $this->request->getPost('nPosition[]');
        $data['shift'] = $this->request->getPost('nShift[]');

        
        
        // if ($data['description'] > getenv('YEAR.END')) {
            //     return redirect()->back()->withInput()->with('error', 'Ano não permitido!');
            // }
            
            try {
                
                $save = $this->allocationModel->saveAllocation($data);

            if ($save) {
                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Operação realizada com sucesso!</p>',
                    //'data' => $this->list()
                ];
                return $this->response->setJSON($response);
            } else{
                return $this->response->setJSON([
                    'status' => 'ERROR',
                    'error' => true,
                    'code' => '',
                    'msg' => '<div class="alert alert-danger alert-close alert-dismissible fade show" role="alert">
                    <strong> <i class="fa fa-exclamation-triangle"></i>  Ops! </strong> Disponibilidade(s) já foi(ram) alocada(s)!! 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>',
                    
                ]);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'status' => 'ERROR',
                'error' => true,
                'code' => $e->getCode(),
                'msg' => '<div class="alert alert-danger alert-close alert-dismissible fade show" role="alert">
                <strong> <i class="fa fa-exclamation-triangle"></i>  Ops! </strong>Erro(s) no preenchimento do formulário! 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>',
                'msgs' => $e->getMessage()
            ]);
        }
        //return $this->response->setJSON($response);
    }

    public function showTeacher(int $id)
    {
        try {

            $data = $this->allocationModel->getAllocationTeacher($id);            

            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }

    }
    public function show(int $id)
    {
        try {

            $data = $this->allocationModel->getTeacherByIdAllocation($id);            

            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }

    }

    public function allocationDel()
    {
        $idAlocacao = $this->request->getPost('id');

        
        try {
            $delete = $this->allocationModel->where('id', $idAlocacao)->delete();

            if ($delete) {
                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Operação realizada com sucesso!</p>',
                    //'data' => $this->list()
                ];
                return $this->response->setJSON($idAlocacao);
            } 
                 

            
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
       

    }
}
