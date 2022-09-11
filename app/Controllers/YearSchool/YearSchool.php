<?php

namespace App\Controllers\YearSchool;

use App\Controllers\BaseController;
use App\Models\YearSchoolModel;

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
            'title' => '<i class="fa fa-calendar-check"></i> Cadastrar Ano Letivo :: ',
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',                
                '<li class="breadcrumb-item active"> Cadastrar </li>',
            ],
            'msgs' => $msgs,
            'erro' => $this->erros,
            'error' => $this->error,
           
        );
        return view('yearSchool/add', $data);
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

       
       

        if($data['description'] > getenv('YEAR.END')){
            return redirect()->back()->withInput()->with('error', 'Ano não permitido!');
        }

        $save = $this->yearSchool->save($data);

        if($save){

            session()->set(['success' => true]);

            return redirect()->to('yearSchool/');
            
        } 
        session()->set(['error' => $this->messageErro]);
        //return redirect()->back()->withInput()->with('error', $this->messageErro);
            

        return redirect()->to('yearSchool/');

    }
}
