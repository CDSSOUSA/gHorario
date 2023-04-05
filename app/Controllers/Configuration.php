<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfigurationModel;
use Exception;

class Configuration extends BaseController
{
    private $configurationModel;

    public function __construct()
    {
        $this->configurationModel = new ConfigurationModel();
    }
    public function getConfiguration()
    {
        try {
            $data = $this->configurationModel->getConfiguration();
            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
    }

    public function createOrUpdate()
    {

        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }
        $val = $this->validate(
            [
                'qtdeDayWeek' => 'required',
                'qtdePosition' => 'required',
                'startDayWeek' => 'required',
                'shiftConfiguration' => 'required',

            ],
            [
                'qtdeDayWeek' => [
                    'required' => 'Preenchimento obrigatório!',

                ],
                'qtdePosition' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'startDayWeek' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'shiftConfiguration' => [
                    'required' => 'Preenchimento obrigatório!',

                ],

            ]
        );

        if (!$val) {

            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => $this->messageError,
                'msgs' => $this->validator->getErrors()
            ];

            return $this->response->setJSON($response);
        }

        $endDayWeek = $this->request->getPost('startDayWeek') + ($this->request->getPost('qtdeDayWeek') - 1);

        if ($endDayWeek > 7) {

            $response = [
                'status' => 'ERROR',
                'error' => true,
                'code' => 400,
                'msg' => $this->messageError,
                'msgs' => ['error' => 'estorou o domingo']
            ];

            return $this->response->setJSON($response);
        }


        if($this->request->getPost('id')) {

            $data['id'] = $this->request->getPost('id');
        }
        $data['qtde_dayWeek'] = $this->request->getPost('qtdeDayWeek');
        $data['start_dayWeek'] = $this->request->getPost('startDayWeek');
        $data['end_dayWeek'] = $endDayWeek;
        $data['qtde_position'] = $this->request->getPost('qtdePosition');
        $data['id_year_school'] = session('session_idYearSchool');
        $data['class_time'] = '45';
        $data['shift'] = $this->request->getPost('shiftConfiguration');
        $textShift = "";

        foreach ($data['shift'] as $it) {

            $textShift .= $it.";";
        }

        $data['shift'] = rtrim($textShift,';');
        $data['status'] = 'A';

        try {

            $save = $this->configurationModel->save($data);
            //$save = true;
            if ($save) {

                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Operação realizada com sucesso!</p>',
                    //'id' =>  $this->disciplineModel->getInsertID()
                    'data' => $data
                ];
                return $this->response->setJSON($response);
            }
        } catch (Exception $e) {

            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage(),
                'data'     => $data
            ]);
        }
    }
}
