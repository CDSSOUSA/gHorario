<?php

namespace App\Controllers\YearSchool;

use App\Controllers\BaseController;
use App\Models\ConfigurationModel;
use App\Models\SeriesModel;
use App\Models\TeacDiscModel;
use App\Models\YearSchoolModel;
use CodeIgniter\API\ResponseTrait;
use Exception;

class YearSchool extends BaseController
{
    use ResponseTrait;
    public $erros = '';
    public $error = '';
    private $yearSchool;
    private $series;
    private $configuration;
    private $teacDisc;

    public function __construct()
    {
        $this->yearSchool = new YearSchoolModel();
        $this->series = new SeriesModel();
        $this->configuration = new ConfigurationModel();
        $this->teacDisc = new TeacDiscModel();
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
        if (session()->has('error')) {
            $this->error = session('error');
            $msgs = $this->messageErro;
        }
        if (session()->has('success')) {
            $msgs = $this->messageSuccess;
        }
        $newJs = [
            base_url() . "/assets/js/year-school.js",
        ];
        $js = array_merge($this->javascript, $newJs);
        $data = array(
            'title' => '<i class="fa fa-calendar-check"></i> Listar Ano Letivo :: ',
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',
                '<li class="breadcrumb-item active"> Listar </li>',
            ],
            'msgs' => $msgs,
            'erro' => $this->erros,
            'error' => $this->error,
            'css' => $this->style,
            'js' => $js,

        );
        return view('yearSchool/list', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }

        $val = $this->validate(
            [
                'description' => 'required|is_unique[tb_year_school.description]',

            ],
            [
                'description' => [
                    'required' => 'Preenchimento obrigatório!',
                    'is_unique' => 'Ano já cadastrado!'
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

        $data = $this->request->getPost();
        $data['status'] = 'A';

        try {

            // $this->yearSchool->transStart();
            // $update = $this->yearSchool->disabledStatus();
            // $save = $this->yearSchool->save($data);
            // $this->yearSchool->transComplete();


            // if ($this->request->getPost('series') == 'S') {

            //     $this->yearSchool->transStart();

            //     $seriesMigration = $this->series->getSeriesByIdYear($data['id_active']);

            //     $this->series->set('status', 'I')
            //         ->where('id_year_school', $data['id_active'])
            //         ->update();

            //     $this->yearSchool->transComplete();


            //     foreach ($seriesMigration as $item) {

            //         $dataSerie['description'] = $item->description;
            //         $dataSerie['classification'] = $item->classification;
            //         $dataSerie['shift'] = $item->shift;
            //         $dataSerie['id_year_school'] = $this->yearSchool->getInsertID();
            //         $dataSerie['status'] = 'A';

            //         $this->series->save($dataSerie);
            //     }

            //     $data['series'] = $seriesMigration;
            // }

            // if ($this->request->getPost('configuration') == 'S') {

            //     $this->yearSchool->transStart();
            //     $configurationMigration = $this->configuration->getConfigurationByIdYear($data['id_active']);

            //     $this->configuration->set('status', 'I')
            //         ->where('id_year_school', $data['id_active'])
            //         ->update();
            //     $this->yearSchool->transComplete();

            //     foreach ($configurationMigration as $item) {

            //         $dataConfiguration['qtde_dayWeek'] = $item->qtde_dayWeek;
            //         $dataConfiguration['start_dayWeek'] = $item->start_dayWeek;
            //         $dataConfiguration['end_dayWeek'] = $item->end_dayWeek;
            //         $dataConfiguration['qtde_position'] = $item->qtde_position;
            //         $dataConfiguration['class_time'] = $item->class_time;
            //         $dataConfiguration['shift'] = $item->shift;
            //         $dataConfiguration['id_year_school'] = $this->yearSchool->getInsertID();
            //         $dataConfiguration['status'] = 'A';

            //         $this->configuration->save($dataConfiguration);
            //     }
            //     $data['configuration'] = $configurationMigration;
            // }

            // if ($this->request->getPost('teacDisc') == 'S') {

            //     $this->yearSchool->transStart();
            //     $teacDiscMigration = $this->teacDisc->getTeacDiscByIdYear($data['id_active']);

            //     $this->teacDisc->set('status', 'I')
            //         ->where('id_year_school', $data['id_active'])
            //         ->update();
            //     $this->yearSchool->transComplete();
            //     foreach ($teacDiscMigration as $item) {

            //         $dataTeacDisc['id_teacher'] = $item->id_teacher;
            //         $dataTeacDisc['id_discipline'] = $item->id_discipline;
            //         $dataTeacDisc['amount'] = $item->amount;
            //         $dataTeacDisc['color'] = $item->color;
            //         $dataTeacDisc['id_year_school'] = $this->yearSchool->getInsertID();
            //         $dataTeacDisc['status'] = 'A';

            //         $this->teacDisc->save($dataTeacDisc);
            //     }

            //     $data['teacDisc'] = $teacDiscMigration;
            // }

            $save = true;
            $update = true;

            if ($save && $update) {
                // $response = [
                //     'status' => 'OK',
                //     'error' => false,
                //     'code' => 200,
                //     'msg' => '<p>Operação realizada com sucesso!</p>',
                //     'data' => $data
                // ];
                return $this->respondCreated([
                    'success'=>'success',

                ],'Operação realizada com sucesso!');
                //return $this->response->setJSON($response);
            }
        } catch (Exception $e) {
            return $this->failServerError('Ocorreu um erro inesperado, tente novamente!', $e->getCode(), $e->getMessage());
        }
        return $this->failServerError('Nenhum registro encontrado!');
    }
    public function active()
    {
        try {
            if ($this->request->getMethod() !== 'post') {
                return redirect()->to('/admin/blog');
            }


            $data = $this->request->getPost();

            $update = $this->yearSchool->updateYearSchool($data);
            //$update = true;

            if ($update) {
                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Operação realizada com sucesso!</p>',
                    //'data' => $this->list()
                ];
                return $this->response->setJSON($response);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
    }

    public function create_()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }
        $val = $this->validate(
            [
                'description' => 'required|is_unique[tb_year_school.description]',
            ],
            [
                'description' => [
                    'required' => 'Preenchimento Obrigatório!',
                    'is_unique' => 'Ano letivo já utilizado!',
                ],

            ]
        );
        if (!$val) {
            return redirect()->back()->withInput()->with('erro', $this->validator);
            //return redirect()->to('/admin/blog');
        }

        $data = $this->request->getPost();
        $data['status'] = 'A';

        if ($data['description'] > getenv('YEAR.END')) {
            return redirect()->back()->withInput()->with('error', 'Ano não permitido!');
        }

        $save = $this->yearSchool->save($data);

        if ($save) {

            session()->set(['success' => true]);

            return redirect()->to('yearSchool/');
        }
        session()->set(['error' => $this->messageErro]);
        //return redirect()->back()->withInput()->with('error', $this->messageErro);


        return redirect()->to('yearSchool/');
    }

    public function list()
    {
        try {
            $data = $this->yearSchool->orderBy('description', 'DESC')->findAll();

            if ($data != null) {
                return $this->response->setJSON($data);
            }
        } catch (Exception $e) {
            return $this->failServerError('Ocorreu um erro inesperado!');
        }
        return $this->failServerError('Nenhum registro encontrado!');
    }

    public function getYearActive()
    {
        try {
            $data = $this->yearSchool->getYearActive();

            if ($data != null) {
                return $this->response->setJSON($data);
            }
        } catch (Exception $e) {
            return $this->failServerError('Ocorreu um erro inesperado!');
        }
        return $this->failServerError('Nenhum registro encontrado!');
    }

    public function show(int $id)
    {
        try {
            $data = $this->yearSchool->find($id);

            if ($data != null) {
                return $this->response->setJSON($data);
            }
        } catch (Exception $e) {
            return $this->failServerError('Ocorreu um erro inesperado!');
        }
        return $this->failServerError('Nenhum registro encontrado!');
    }

    public function update()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }

        $val = $this->validate(
            [
                'description' => 'required|is_unique[tb_year_school.description,id,{id}]',

            ],
            [
                'description' => [
                    'required' => 'Preenchimento obrigatório!',
                    'is_unique' => 'Ano já cadastrado!'
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

        $data = $this->request->getPost();
        //$data['status'] = 'I';

        $save = $this->yearSchool->save($data);

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
}
