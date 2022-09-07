<?php

namespace App\Controllers;

use App\Controllers\Horario\Horario as HorarioController;

class Home extends BaseController
{
    public function __construct()
    {
        $this->menu = [
            'itens' => [
                'item' => [
                    'account' => [
                        'title' => 'Conta Bancária',
                        'links'   => [
                           'Cadastrar' => '/account/add',
                           'Listar' => '/account/list',
                           'Saldo' => '/account/balance',
                         
                        ],
                        'icon' => '<i class="nav-icon far fa-money-bill-alt"></i>',
                    ],
                    'rubrica' => [
                        'title' => 'Rubrica',
                        'links'   => [
                            'Cadastrar' => '/rubrica/add',
                            'Listar' => '/rubrica/list'
                        ],
                        'icon' => '<i class="nav-icon fas fa-clipboard-list"></i>',
                    ],
                    'movement' => [
                        'title' => 'Movimentação',
                        'links'   => [
                            'Cadastrar' => '/movement/add',
                            'Listar' => '/movement/resume/'.date('m').'/'.date("Y"),
                            'Consultar' => [
                                'Rubrica' => '/movement/search/rubrica',
                                'Data' => '/movement/search/data',
                                'Origem' => '/movement/search/origem',
                            ]
                        ],
                        'icon' => '<i class="nav-icon far fa-calendar-alt"></i>',
                    ],
                ]
            ]

        ];
    }
    public function index()
    {
        //return view('main/content');
        
        $n = new HorarioController();
        return $n->index();

    }
    public function logout()
    {
       if(session()->get('isLoggedIn')){
           session()->remove('isLoggedIn');
           return redirect()->to(getenv('URL.LOGIN'));

       }
      
    }

    
}
