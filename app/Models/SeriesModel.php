<?php

namespace App\Models;

use CodeIgniter\Model;

class SeriesModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'tb_series';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['description', 'classification', 'shift', 'id_year_school', 'status'];

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    public function getSeries(string $shift): array
    {
        $this->where('shift', $shift)
            ->where('status', 'A')
            ->orderBy('description');
        $result = $this->findAll();
        return !is_null($result) ? $result : [];
    }

    public function getDescription(int $id)
    {
        $return = $this->select('description,classification,shift,status')
            ->where('id', $id)
            ->get()
            ->getResult();
        return $return;
    }

    public function updateSeries(array $data)
    {
        $status = $data['status'] == 'A' ? 'I' : 'A';
        
        $schedule = new SchoolScheduleModel();
        $schedule->where('id_series', $data['id'])
            ->delete();
        // testar no caso de desabilitar a série deletar todos horarios, depois alocacao    

        $update = $this->set('status', $status)
            ->where('id', $data['id'])
            ->update();
        if ($schedule && $update) {

            return true;
        }
        return false;
    }
}
