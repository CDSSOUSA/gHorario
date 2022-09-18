<?php

namespace App\Controllers\Allocation;

use App\Controllers\BaseController;
use Exception;

class Allocation extends BaseController
{
    public function create()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/blog');
        }
        $val = $this->validate(
            [
                'id_teacher' => 'required',
                'amount' => 'required',
                'color' => 'required|is_unique[tb_teacher_discipline.color]',
                'disciplinesTeacher' => 'required',
            ],
            [
                'id_teacher' => [
                    'required' => 'Preenchimento obrigatório!',
                   
                ],
                'amount' => [
                    'required' => 'Preenchimento obrigatório!',
                ],
                'color' => [
                    'required' => 'Preenchimento obrigatório!',
                    'is_unique' => 'Cor utilizada por outro (a) professor (a)!',
                ],
                'disciplinesTeacher' => [
                    'required' => 'Preenchimento obrigatório!',                    
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

       

        $teacher['id_teacher'] = mb_strtoupper($this->request->getPost('id_teacher'));
        $teacher['amount'] = $this->request->getPost('amount');
        $teacher['color'] = $this->request->getPost('color') == '#000000' ? generationColor() : $this->request->getPost('color') ;
        $teacher['disciplines'] = $this->request->getPost('disciplinesTeacher');
        $teacher['status'] = 'A';       
        //$data['status'] = 'A';

        // if ($data['description'] > getenv('YEAR.END')) {
        //     return redirect()->back()->withInput()->with('error', 'Ano não permitido!');
        // }
        
        try{
            $save = $this->teacDiscModel->saveTeacherDiscipline($teacher);

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
        }catch (Exception $e) {
            return $this->response->setJSON([
                'status' => 'ERROR',
                'error' => true,
                'code' => $e->getCode(),
                'msg' => '<div class="alert alert-danger alert-close alert-dismissible fade show" role="alert">
                <strong> <i class="fa fa-exclamation-triangle"></i>  Ops! </strong>Erro(s) no preenchimento do formulário! 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>', 
                'msgs' => [
                    'disciplinesTeacher' => 'Disciplina já cadastrada!'  
                ]            
            ]);          
        }
        //return $this->response->setJSON($response);
    }
}
