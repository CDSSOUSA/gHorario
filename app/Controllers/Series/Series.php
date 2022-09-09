<?php

namespace App\Controllers\Series;

use App\Controllers\BaseController;
use Exception;
use App\Models\SeriesModel;

class Series extends BaseController
{
    public function show(int $id)
    {
        try {

            $series  = new SeriesModel();
            $data = $series->getDescription($id);
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
}
