<?php

namespace App\Controllers\Discipline;

use App\Controllers\BaseController;
use App\Models\DisciplineModel;
use App\Models\TeacDiscModel;
use Exception;

class Discipline extends BaseController
{
    private $disciplineModel;
    private $teacDiscModel;

    public function __construct()
    {
        $this->disciplineModel = new DisciplineModel();
        $this->teacDiscModel = new TeacDiscModel();
    }
    // public function show()
    // {
    //     $data = [
    //         'title' => '<i class="fa fa-book"></i> Listar Disciplinas :: ',
    //         'breadcrumb' => [
    //             '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',
    //             '<li class="breadcrumb-item active"> Listar </li>'
    //         ],
    //         'disciplines' => $this->disciplineModel->findAll(),

    //     ];
    //     //session()->set('dado',$data);
    //     return view('discipline/list', $data);
    // }
    public function show()
    {
        $newJs = [
            base_url() . "/assets/js/discipline.js",
        ];
        $js = array_merge($this->javascript, $newJs);

        $data = [
            'title' => 'LISTAR DISCIPLINAS :: ',
            'breadcrumb' => [
                '<li class="breadcrumb-item">' . anchor('/', 'Home') . '</li>',
                '<li class="breadcrumb-item active"> Listar </li>'
            ],
            'disciplines' => $this->disciplineModel->findAll(),
            'css' => $this->style,
            'js' => $js,


        ];
        //session()->set('dado',$data);
        return view('discipline/list', $data);
    }
    public function list()
    {
        try {

            $data = $this->disciplineModel->orderBy('description', 'ASC')->findAll();

            foreach ($data as $key => $item) {

                $teacDisc = $this->teacDiscModel->where('id_discipline', $item->id)->get()->getResult();

                if ($teacDisc) {
                    $data[$key]->teacDisc = true;
                }
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

    public function edit(int $id)
    {
        try {

            $data = $this->disciplineModel->find($id);

            // $teacDisc = $this->teacDiscModel->where('id_discipline', $id)->get()->getResult();

            // if($teacDisc) {
            //     $data->teacDisc = true;
            // }

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
                'description' => 'required|min_length[3]|is_unique[tb_discipline.description]',
                'amount' => 'required',
                'icone' => 'required',
                'abbreviation' => 'required|min_length[3]|max_length[6]|is_unique[tb_discipline.abbreviation]',

            ],
            [
                'description' => [
                    'required' => 'Preenchimento obrigat??rio!',
                    'min_length' => 'M??nimo permitido 3 caracteres!',
                    'is_unique' => 'Disciplina j?? utilizada!'
                ],
                'amount' => [
                    'required' => 'Preenchimento obrigat??rio!',
                ],
                'icone' => [
                    'required' => 'Preenchimento obrigat??rio!',
                ],
                'abbreviation' => [
                    'required' => 'Preenchimento obrigat??rio!',
                    'max_length' => 'M??nimo permitido 6 caracteres!',
                    'min_length' => 'M??nimo permitido 3 caracteres!',
                    'is_unique' => 'Abrevia????o j?? utilizada!'
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
                        </div>',
                'msgs' => $this->validator->getErrors()
            ];

            return $this->response->setJSON($response);
        }

        $data['abbreviation'] = mb_strtoupper($this->request->getPost('abbreviation'));
        $data['description'] = mb_strtoupper($this->request->getPost('description'));
        $data['amount'] = mb_strtoupper($this->request->getPost('amount'));
        $data['icone'] = $this->request->getPost('icone');
        try {

            $save = $this->disciplineModel->save($data);
            if ($save) {

                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Opera????o realizada com sucesso!</p>',
                    //'data' => $this->list()
                ];
                return $this->response->setJSON($data);
            }
        } catch (Exception $e) {

            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'N??o foi poss??vel executar a opera????o',
                'error'    => $e->getMessage(),
                'data'     => $data
            ]);
        }
    }

    public function update()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }
        $val = $this->validate(
            [
                'description' => 'required|min_length[3]',
                'amount' => 'required',
                'abbreviation' => 'required|min_length[3]|max_length[6]',

            ],
            [
                'description' => [
                    'required' => 'Preenchimento obrigat??rio!',
                    'min_length' => 'M??nimo permitido 3 caracteres!',

                ],
                'amount' => [
                    'required' => 'Preenchimento obrigat??rio!',
                ],
                'abbreviation' => [
                    'required' => 'Preenchimento obrigat??rio!',
                    'max_length' => 'M??nimo permitido 6 caracteres!',
                    'min_length' => 'M??nimo permitido 3 caracteres!',

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
                        </div>',
                'msgs' => $this->validator->getErrors()
            ];

            return $this->response->setJSON($response);
        }

        $data['abbreviation'] = mb_strtoupper($this->request->getPost('abbreviation'));
        $data['description'] = mb_strtoupper($this->request->getPost('description'));
        $data['amount'] = mb_strtoupper($this->request->getPost('amount'));
        $data['id'] = mb_strtoupper($this->request->getPost('id'));
        try {

            $save = $this->disciplineModel->save($data);
            if ($save) {

                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Opera????o realizada com sucesso!</p>',
                    //'data' => $this->list()
                ];
                return $this->response->setJSON($response);
            }
        } catch (Exception $e) {

            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'N??o foi poss??vel executar a opera????o',
                'error'    => $e->getMessage(),
                'data'     => $data
            ]);
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        try {
            $delete = $this->disciplineModel->where('id', $id)->delete();

            if ($delete) {
                $response = [
                    'status' => 'OK',
                    'error' => false,
                    'code' => 200,
                    'msg' => '<p>Opera????o realizada com sucesso!</p>'
                ];
                return $this->response->setJSON($response);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => '<div class="alert alert-danger alert-close alert-dismissible fade show" role="alert">
                <strong> <i class="fa fa-exclamation-triangle"></i>  Ops! </strong>N??o foi poss??vel executar a opera????o! 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>',
                'error'    => $e->getMessage(),
            ]);
        }
    }
}
