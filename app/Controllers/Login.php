<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Exception;

class Login extends BaseController
{
    use ResponseTrait;
    public function login()
    {
        try {

            if ($this->request->getMethod() !== 'post') {
                return '$this->index();';
            }
            $val = $this->validate(
                [
                    'token' => 'required',
                ],
                [
                    'token' => [
                        'required' => 'Preenchimento obrigatório!',
                    ]
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

            $token = $this->request->getPost('token');

            if($token != getenv('TOKEN.ACCESS')){
                $response = [
                    'status' => 'ERROR',
                    'error' => true,
                    'code' => 404,
                    'msg' => $this->messageErrorLogin,
                    'msgs' => 'Dados não conferem'
                ];
                return $this->response->setJSON($response);
            } 

            $response = [
                'status' => 'OK',
                'error' => false,
                'code' => 200,
                'msg' => '<p>Operação realizada com sucesso!</p>',                
            ];
            //setcookie("token", $this->generateJWT());
            return $this->response->setJSON($response);

        } catch (Exception $e) {
            return $this->failServerError('Ocorreu um erro inesperado!');
        }
    }
}
