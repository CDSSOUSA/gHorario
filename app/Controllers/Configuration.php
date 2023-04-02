<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfigurationModel;
use Exception;

class Configuration extends BaseController
{
    private $configurationModel;

    public function __construct()
    {
        $this->configurationModel = new ConfigurationModel();
    }
    public function getConfigurationById(int $idYearSchool)
    {
        try {
            $data = $this->configurationModel->getConfigurationById($idYearSchool);          
            return $this->response->setJSON($data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'response' => 'Erros',
                'msg'      => 'Não foi possível executar a operação',
                'error'    => $e->getMessage()
            ]);
        }
    }
}
