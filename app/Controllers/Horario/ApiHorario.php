<?php

namespace App\Controllers\Horario;

use App\Models\AllocationModel;
use App\Models\SchoolScheduleModel;
use App\Models\TeacDiscModel;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use App\Models\DisciplineModel;
use App\Models\SeriesModel;

class ApiHorario extends ResourceController
{
    private $allocation;
    private $schedule;
    private $teacDisc;
    private $discipline;
    private $seriesModel;
    public function __construct()
    {
        $this->allocation = new AllocationModel();
        $this->schedule = new SchoolScheduleModel();
        $this->teacDisc = new TeacDiscModel();
        $this->discipline = new DisciplineModel();
        $this->seriesModel = new SeriesModel();
    }

    public function listDPS($idSerie, $dw, $ps, $shift)
    {
        try {
            //define array limites
            $limits = [];
            // buscou as series
            $dataSerie = $this->schedule->getTotalDiscBySerie($idSerie);

            $horario = $this->schedule->getTimeDayWeek($dw, $idSerie, $ps);

            // if(!empty($horario)) {

            //     $id_teacher = [$horario['id_teacher']];
            // } else {
            //     $id_teacher = ['0'];
            // }
            // if exitir
            if ($dataSerie != null) {
                //
                foreach ($dataSerie as $d) {
                    //busca o limite por serie da disciplina
                    $limit = $this->discipline->getLimitClassroom($d->id);
                    //if total limite da disciplina for menor igual a total de alocacao na 
                    // $disciplineTeacher = $this->schedule->getDisciplineTeacher($d->id_series);

                    // $dis = [];
                    // $tea = [];
                    // if($disciplineTeacher != null){

                    //     foreach ($disciplineTeacher as $is) {    
                    //         $dis[] = $is->id_discipline;
                    //         $tea[] = $is->id_teacher;
                    //     }
                    // }

                    if ($limit->amount <= $d->total) {
                        $limits[] = $d->id;
                    }
                    
                }
                if ($limits != null) {
                    //$allocationDisponivel = $this->allocation->getAllocationByDayWeek($idSerie, $dw, $ps, $shift, $limits,$dis,$tea);
                    $allocationDisponivel = $this->allocation->getAllocationByDayWeek($idSerie, $dw, $ps, $shift, $limits);
                } 
                // else if($disciplineTeacher != null){

                //     $data = $this->allocation->getAllocationByDayWeekABC($idSerie, $dw, $ps, $shift, $limits, $dis, $tea);
                    
                    
                // }
                else {

                    $allocationDisponivel = $this->allocation->getAllocationByDayWeekA($idSerie, $dw, $ps, $shift);
                }
            } else {

                $allocationDisponivel = $this->allocation->getAllocationByDayWeekA($idSerie, $dw, $ps, $shift);
            }

            $horario2 = $this->schedule->getTimePosition($dw, $ps, $shift);

            $allocationDisponivel2 = 'vago';
            if ($horario2 != null) {
                foreach ($horario2 as $h) {
                    $hor[] = $h->id_teacher;
                }

                $allocationDisponivel2 = $this->allocation->getAllocationByDayWeekAB($idSerie, $dw, $ps, $shift, $hor);

                //dd($allocationDisponivel2);
            }



            //  if($horario2['id_teacher']) {

            //      $allocationDisponivel = $this->allocation->getAllocationByDayWeekAB($idSerie, $dw, $ps, $shift, $horario2);
            //  }  



            $data = 'ocupada';

            if ($allocationDisponivel != null && empty($horario) && !empty($allocationDisponivel2)) {
                $data = 'livre';
            } else if (empty($horario)) {
                $data = 'vago';
            } else {
                $data = $horario;
            }

            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'N??o foi poss??vel executar a opera????o',
                'error'    => $e->getMessage()
            ]);
        }
    }
    public function list(string $shift)
    {
        try {


            $dataSerie = $this->seriesModel->getSeries($shift);



            // foreach ($data as $key => $item) {

            //     $teacDisc = $this->teacDiscModel->where('id_discipline', $item->id)->get()->getResult();

            //     if ($teacDisc) {
            //         $data[$key]->teacDisc = true;
            //     }
            // }

            return $this->response->setJSON($dataSerie);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'N??o foi poss??vel executar a opera????o',
                'error'    => $e->getMessage()
            ]);
        }
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
                    // $disciplineTeacher = $this->schedule->getDisciplineTeacher($d->id_series);

                    // $dis = [];
                    // $tea = [];
                    // if($disciplineTeacher != null) {

                    //     foreach ($disciplineTeacher as $is) {
    
                    //         $dis[] = $is->id_discipline;
                    //         $tea[] = $is->id_teacher;
                    //     }
                    // }

                    if ($limit->amount <= $d->total) {
                        $limits[] = $d->id;
                    }
                }
                if ($limits != null) {
                    $data = $this->allocation->getAllocationByDayWeek($idSerie, $dayWeek, $position, $shift, $limits);
                } 
                // else if($disciplineTeacher != null){

                //     $data = $this->allocation->getAllocationByDayWeekABC($idSerie, $dayWeek, $position, $shift, $limits, $dis, $tea);
                    
                    
                // }
                else {
                    $horario = $this->schedule->getTimePosition($dayWeek, $position, $shift);
                    if ($horario) {

                        foreach ($horario as $h) {
                            $hor[] = $h->id_teacher;
                        }

                        $data = $this->allocation->getAllocationByDayWeekAB($idSerie, $dayWeek, $position, $shift, $hor);
                    } else {

                        $data = $this->allocation->getAllocationByDayWeekA($idSerie, $dayWeek, $position, $shift);
                    }
                }
            } else {

                $data = $this->allocation->getAllocationByDayWeekA($idSerie, $dayWeek, $position, $shift);
            }



            if ($data != null) {
                return $this->response->setJSON($data);
            } else {
                $data = [[
                    'id' => "0",
                    'name' => "SEM PROFESSOR",
                    'abbreviation' => "SH",
                    'color' => "#000000",
                    'id_teacher' => "0"
                ]];
                //$data = 'vago';
                return $this->response->setJSON($data);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'N??o foi poss??vel executar a opera????o',
                'error'    => $e->getMessage()
            ]);
        }
        return $this->response->setJSON([
            'response' => 'Warning',
            'msg'      => 'Nenhum usu??rio encontrado para essa pesquisa!',
        ]);
    }
    public function getOcupationSchedule(int $idAllocation)
    {
        try {

            $data = $this->schedule->getScheduleByIdAllocation($idAllocation);

            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'N??o foi poss??vel executar a opera????o',
                'error'    => $e->getMessage()
            ]);
        }
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
                    'required' => 'Preenchimento Obrigat??rio!',
                ],
            ]
        );

        if (!$val) {

            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => '<div class="alert alert-danger alert-close alert-dismissible fade show" role="alert">
  <strong> <i class="fa fa-exclamation-triangle"></i>  Ops! </strong>Erro(s) no preenchimento do formul??rio! 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
        $horario['id_year_school'] = session('session_idYearSchool');

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
                    ->where('id_year_school', session('session_idYearSchool'))
                    ->update();
            }

            $response = [
                'status' => 'OK',
                'error' => false,
                'code' => 200,
                'msg' => '<p>Opera????o realizada com sucesso!</p>',
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
                        ->where('id_year_school', session('session_idYearSchool'))
                        ->update();
                    //}


                    $delete = $this->schedule->where('id', $data->id)
                        ->delete();
                    if ($delete) {
                        $response = [
                            'status' => 'OK',
                            'error' => false,
                            'code' => 200,
                            'msg' => '<p>Opera????o realizada com sucesso!</p>'
                        ];
                        return $this->response->setJSON($response);
                    }
                }
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'N??o foi poss??vel executar a opera????o',
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
            $data = $this->schedule->getDataForDelete($id);
            // definir nova consuta para todos os dados da schedule

            if ($data != null) {
                return $this->response->setJSON($data);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'N??o foi poss??vel executar a opera????o',
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
        //         'msg' => '<p>Opera????o realizada com sucesso!</p>'
        //     ];
        //     return $this->response->setJSON($response);
        // }
    }
}
