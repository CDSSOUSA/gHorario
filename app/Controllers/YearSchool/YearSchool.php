<?php

namespace App\Controllers\YearSchool;

use App\Controllers\BaseController;
use App\Models\YearSchoolModel;
use Exception;

class YearSchool extends BaseController
{
    public $erros = '';
    public $error = '';
    private $yearSchool;

    public function __construct()
    {
        $this->yearSchool = new YearSchoolModel();
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
        $data = array(
            'title' => '<i class="fa fa-calendar-check"></i> Listar Ano Letivo :: ',
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',
                '<li class="breadcrumb-item active"> Listar </li>',
            ],
            'msgs' => $msgs,
            'erro' => $this->erros,
            'error' => $this->error,

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

        $data = $this->request->getPost();
        $data['status'] = 'I';

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
            $data = $this->yearSchool->findAll();

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
    }
}
