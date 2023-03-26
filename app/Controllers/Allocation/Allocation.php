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
                'disciplinesTeacher' => 'required',
                // 'nPosition' => 'required',
                'nDayWeek' => 'required',
                'nShift' => 'required',
            ],
            [
                'id_teacher' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                // 'nPosition' => [
                //     'required' => 'Preenchimento obrigatório!',
                // ],
                'nDayWeek' => [
                    'required' => 'Preenchimento obrigatório!',

                ],
                'nShift' => [
                    'required' => 'Preenchimento obrigatório!',

                ],
                'disciplinesTeacher' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
            ]
        );

        if (!$val) {

            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => '<div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-text"><strong>Ops! </strong>Erro(s) no preenchimento do formulário! </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>',
                'msgs' => $this->validator->getErrors()
            ];

            return $this->response->setJSON($response);
        }

        $idTeacher = $this->request->getPost('id_teacher');
        $data['dayWeek'] = $this->request->getPost('nDayWeek[]');
        $data['disciplines'] = $this->request->getPost('disciplinesTeacher');
        // $data['position'] = $this->request->getPost('nPosition[]');
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
                    'msg' => '<div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-text"><strong>Ops! </strong> Disponibilidade(s) já foi(ram) alocada(s)!! </span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
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
                'msg' => '<div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-text"><strong>Ops! </strong>Erro(s) no preenchimento do formulário! catc </span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
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

            $data = $this->allocationModel->getAllocationTeacherOcupation($id);  
            // atencao apra o metodo  getAllocationTeacher        

            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }

    }
    public function showTeacherChecked(int $id)
    {
        try {

            $data = $this->allocationModel->getAllocationTeacher($id);  
            // atencao apra o metodo  getAllocationTeacher        

            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }

    }
    public function getTotalAllocationTeacher(int $id)
    {
        try {

            $data = $this->allocationModel->getAllocationTeacherAll($id);  
            // atencao apra o metodo  getAllocationTeacher        

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
        //$idAlocacao = $this->request->getPost('id_teacher"');
        $data['id'] = $this->request->getPost('id_teacher');
        $data['nIdsAllocation'] = $this->request->getPost('nIdsAllocation[]');

        $allocationProtected = [];

        if($data['nIdsAllocation'] ) {
            
            foreach ($data['nIdsAllocation'] as $item){
                array_push($allocationProtected, $item);
            }
        }


        
        try {

            $allocationFree = $this->allocationModel->getAllocationTeacherFree($data['id']);

            foreach($allocationFree as $idAllocation ) {

                if(!in_array($idAllocation->id,$allocationProtected)){
                    
                    $delete = $this->allocationModel->where('id', $idAllocation->id)->delete();
                }

            }

            if ($delete) {
                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Operação realizada com sucesso!</p>',
                    //'data' => $this->list()
                ];
                return $this->response->setJSON($data);
            }     

            
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => '<div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-text"><strong>Ops! </strong> Precisa desmarcar pelo menos uma opção!!</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>',
                'error'    => $e->getMessage()
            ]);
        }
       

    }
}
