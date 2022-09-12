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

        }
        catch (Exception $e) {
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
           
            $data = $this->series->findAll();
            return $this->response->setJSON($data);

        }
        catch (Exception $e) {
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

    
}
