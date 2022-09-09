<?php

namespace App\Controllers\Horario;

use App\Models\AllocationModel;
use App\Models\SchoolScheduleModel;
use App\Models\TeacDiscModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use App\Models\DisciplineModel;

class ApiHorario extends ResourceController
{
    private $allocation;
    private $schedule;
    private $teacDisc;
    private $discipline;
    public function __construct()
    {
        $this->allocation = new AllocationModel();
        $this->schedule = new SchoolScheduleModel();
        $this->teacDisc = new TeacDiscModel();
        $this->discipline = new DisciplineModel();
    }

    public function getAllocation(int $idSerie, int $dayWeek, int $position, string $shift)
    {
        try {
            $datas = $this->schedule->getTotalDiscBySerie($idSerie);
            $ar = 0;
            $limits = [];
            if ($datas != null) {

                foreach ($datas as $d) {

                    $limit = $this->discipline->getLimitClassroom($d->id);
                    if ($limit->amount <= $d->total) {
                        $limits[] = $d->id;
                    }
                }
                if ($limits != null) {

                    $data = $this->allocation->getAllocationByDayWeek($idSerie, $dayWeek, $position, $shift, $limits);
                } else {

                    $data = $this->allocation->getAllocationByDayWeekA($idSerie, $dayWeek, $position, $shift);
                }
            } else {

                $data = $this->allocation->getAllocationByDayWeekA($idSerie, $dayWeek, $position, $shift);
            }

            if ($data != null) {
                return $this->response->setJSON($data);
            } else {
                $data = [[
                    'id'=> "0",
                    'name'=> "SEM PROFESSOR",
                    'abbreviation'=> "SH",
                    'color'=> "#000000", 
                    'id_teacher'=> "0"
                ]];
                return $this->response->setJSON($data);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
        return $this->response->setJSON([
            'response' => 'Warning',
            'msg'      => 'Nenhum usuário encontrado para essa pesquisa!',
        ]);
    }
    public function create()
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

            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Ops!</strong> Erro(s) no preenchimento do formulário! 
  <button type="button" class="close" data-dismiss="alert" aria-bs-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>'
            ];

            return $this->response->setJSON($response);
        }

        $horario['id_allocation'] = $this->request->getPost('nIdAlocacao');
        $horario['dayWeek'] = $this->request->getPost('nDayWeek');
        $horario['position'] = $this->request->getPost('nPosition');
        $horario['id_series'] = $this->request->getPost('nSerie');
        //$horario['id_ano_letivo'] = 1;
        $horario['status'] = 'A';

        $save = $this->schedule->save($horario);

        if ($save) {

            $allocationId = $horario['id_allocation'];
            //RECUPERA OS ID_TEACHER_DISCIPLINE
            $teacherDiscipline = $this->allocation->getTeacherByIdAllocation($allocationId);

            //RECUPERA OS ID
            $teacDisc = $this->teacDisc->find($teacherDiscipline[0]->id_teacher_discipline);

            //TOTAL 
            $total = $teacDisc->amount;

            $this->allocation->set('situation', 'O')
                ->where('id', $allocationId)
                ->update();

            //TOTAL DE ALOCACAO
            $totalAllocation = $this->allocation->getCountByIdTeacDiscOcupation($teacherDiscipline[0]->id_teacher_discipline);
            if ($total <= $totalAllocation) {

                $this->allocation->set('situation', 'B')
                    ->where('id_teacher_discipline', $teacherDiscipline[0]->id_teacher_discipline)
                    ->where('situation', 'L')
                    ->update();
            }

            $response = [
                'status' => 'OK',
                'error' => false,
                'code' => 200,
                'msg' => '<p>Operação realizada com sucesso!</p>',
                'total' => $total,
                'totalAll' => $totalAllocation,
            ];
            return $this->response->setJSON($response);
        }
    }

    public function del()
    {
        $id = $this->request->getPost('id');

        try {
            $data = $this->schedule->find($id);

            if ($data != null) {

                $id_allocation = $data->id_allocation;
                $allocation = $this->allocation->set('situation', 'L')
                    ->where('id', $id_allocation)
                    ->update();

                if ($allocation) {

                    //RECUPERA OS ID_TEACHER_DISCIPLINE
                    $teacherDiscipline = $this->allocation->getTeacherByIdAllocation($id_allocation);

                    // //RECUPERA OS ID
                    // $teacDisc = $this->teacDisc->find($teacherDiscipline[0]->id_teacher_discipline);

                    // //TOTAL 
                    // $total = $teacDisc->amount;

                    // //TOTAL DE ALOCACAO
                    // $totalAllocation = $this->allocation->getCountByIdTeacDiscOcupation($teacherDiscipline[0]->id_teacher_discipline);
                    // if ($total <= $totalAllocation) {

                    $this->allocation->set('situation', 'L')
                        ->where('id_teacher_discipline', $teacherDiscipline[0]->id_teacher_discipline)
                        ->where('situation', 'B')
                        ->update();
                    //}


                    $delete = $this->schedule->where('id', $data->id)
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
                }
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
        return $this->response->setJSON([
            'response' => 'Warning',
            'msg'      => 'Nenhum registro encontrado para essa pesquisa!',
        ]);
    }

    public function deleteSchedule(int $id)
    {

        try {
            $data = $this->schedule->find($id);

            if ($data != null) {
                return $this->response->setJSON($data);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }

        return $this->response->setJSON([
            'response' => 'Warning',
            'msg'      => 'Nenhum registro encontrado para essa pesquisa!',
        ]);

        // $delete = $this->schedule->where('id', $id)
        //     ->delete();
        // if ($delete) {
        //     $response = [
        //         'status' => 'OK',
        //         'error' => false,
        //         'code' => 200,
        //         'msg' => '<p>Operação realizada com sucesso!</p>'
        //     ];
        //     return $this->response->setJSON($response);
        // }
    }
}
