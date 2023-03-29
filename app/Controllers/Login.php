<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Exception;

class Login extends BaseController
{
    private $validateToken;
    public function __construct()
    {
       
        $this->validateToken = new Services();
    }
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
            $tokenAccess = getenv('TOKEN.ACCESS');

            $validateToken = base64_encode(hash_hmac('sha256', $token, true));
            $validateTokenAccess = base64_encode(hash_hmac('sha256', $tokenAccess, true));
         


            if($validateToken != $validateTokenAccess){
                throw new Exception('Error');
                // $response = [
                //     'status' => 'ERROR',
                //     'error' => true,
                //     'code' => 404,
                //     'msg' => $this->messageErrorLogin,
                //     'msgs' => 'Dados não conferem'
                // ];
                // return $this->response->setJSON($response);
            } 

                 
            //setcookie("tokens", $this->generateJWT());

            $response = [
                'status' => 'OK',
                'error' => false,
                'code' => 200,
                'msg' => '<p>Operação realizada com sucesso!</p>',
                'tokenNew' => $this->generateJWT(),                
            ];
            //setcookie("token", $this->generateJWT());
            return $this->response->setJSON($response);

        } catch (Exception $e) {
            return $this->failServerError('Ocorreu um erro inesperado!');
        }
    }

    public function validateToken () {

        $tokenHeader = $this->request->getHeaderLine('Authorization');
        //dd($tokenHeader);
        //$token = $this->request->getPost('token');

        //$tokenAccess = getenv('TOKEN.ACCESS');
        //$validateToken = $this->validateTokenJWT($token);
       
        if(!$this->validateToken->validateToken($tokenHeader)){
            throw new Exception('Error');
            // $response = [
            //     'status' => 'ERROR',
            //     'error' => true,
            //     'code' => 404,
            //     'msg' => $this->messageErrorLogin,
            //     'token' => $tokenHeader,
            //     'tokenValidate' => $tokenHeader
            // ];
            //return $this->response->setJSON($response);

            
        }

       
        $response = [
            'status' => 'OK',
            'error' => false,
            'code' => 200,
            'msg' => '<p>Operação realizada com sucesso!</p>',
            'msgs' => 'token válido',
            'token' => $tokenHeader,
            'tokenvalidate' => $tokenHeader
                          
        ];
        //setcookie("token", $this->generateJWT());
        return $this->response->setJSON($response);
       
         

    }

    protected function generateJWT()
    {
        $key = Services::getSecretKey();
        $time = time();

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $h = base64_encode(json_encode($header));

        $payload = [
            //'aud' => base_url(),
            'iat' => $time,
            'exp' => $time + 60,
            // 'data'=> [
            //     'login' => $usuario['login'],
            //     'id_system' => $usuario['id_system']
            // ]
        ];

        //$jwt = JWT::encode($payload,$key, 'HS256');
        $p = base64_encode(json_encode($payload));

        $s = base64_encode(hash_hmac('sha256', $h . '.' . $p, $key, true));

        $jwt = $h . "." . $p . "." . $s;

        return $jwt;
    }

    protected function validateTokenJWT($token)
    {
        $dados = explode('.', $token);

        $header = $dados[0];
        $payload = $dados[1];
        $signature = $dados[2];

        $key = Services::getSecretKey();

        $validate = base64_encode(hash_hmac('sha256', $header . '.' . $payload, $key, true));
        $time_exp = json_decode(base64_decode($payload));      
        
        if ($signature == $validate && $time_exp->exp > time()) {            
            
            return true;
        }
        return false;
    }
    
}
