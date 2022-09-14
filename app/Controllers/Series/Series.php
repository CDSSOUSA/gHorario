<?php

namespace App\Controllers\Series;

use App\Controllers\BaseController;
use Exception;
use App\Models\SeriesModel;

class Series extends BaseController
{
    public $erros = '';
    public $error = '';
    private $series;

    public function __construct()
    {
        $this->series = new SeriesModel();
    }
    public function show(int $id)
    {
        try {

            $data = $this->series->getDescription($id);
            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
    }
    public function listSeries()
    {
        try {

            $data = $this->series->orderBy('shift ASC, description ASC ,classification ASC')->findAll();
            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
    }

    public function active()
    {
        try {
            if ($this->request->getMethod() !== 'post') {
                return redirect()->to('/admin/blog');
            }


            $data = $this->request->getPost();

            $update = $this->series->updateSeries($data);
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
        if (session()->has('error')) {
            $this->error = session('error');
            $msgs = $this->messageErro;
        }
        if (session()->has('success')) {
            $msgs = $this->messageSuccess;
        }
        $data = array(
            'title' => '<i class="fa fa-calendar-check"></i> Listar Séries :: ',
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',
                '<li class="breadcrumb-item active"> Listar </li>',
            ],
            'msgs' => $msgs,
            'erro' => $this->erros,
            'error' => $this->error,

        );
        return view('series/list', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }
        $val = $this->validate(
            [
                'description' => 'required|max_length[1]|integer',
                'classification' => 'required|alpha',
                'shift' => 'required',

            ],
            [
                'description' => [
                    'required' => 'Preenchimento Obrigatório!',
                    'max_length' => 'Apenas um caracter!',
                    'integer' => 'Apenas número inteiro!'
                ],
                'classification' => [
                    'required' => 'Preenchimento Obrigatório!',
                    'alpha' => 'Apenas letras!',
                ],
                'shift' => [
                    'required' => 'Preenchimento Obrigatório!',
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
        $data['classification'] = mb_strtoupper($this->request->getPost('classification'));
        //$data['status'] = 'A';

        // if ($data['description'] > getenv('YEAR.END')) {
        //     return redirect()->back()->withInput()->with('error', 'Ano não permitido!');
        // }

        $save = $this->series->save($data);

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
