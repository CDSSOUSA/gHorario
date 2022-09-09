<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolScheduleModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'tb_school_schedule';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id_allocation','dayWeek','position','id_series','status'];

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

    public function getTimeDayWeek(int $diaSemana, int $idSerie, int $posicao)
    {

        $result = $this->select(
            'p.name, 
            h.id_allocation, 
            pd.color, 
            pd.id_teacher,
            d.abbreviation,
            h.id')
            ->from('tb_school_schedule h')
            ->join('tb_allocation ap', 'h.id_allocation = ap.id')
            ->join('tb_teacher_discipline pd', 'ap.id_teacher_discipline = pd.id')
            ->join('tb_discipline d', 'pd.id_discipline = d.id')
            ->join('tb_teacher p', 'pd.id_teacher = p.id')
            ->where('h.dayWeek', $diaSemana)
            ->where('h.id_series', $idSerie)
            ->where('h.position', $posicao)
            ->get()->getRowArray();            
            return $result;
    }

    public function getScheduleByIdAllocation(int $idAllocation)
    {
        return $this->where('id_allocation',$idAllocation)
        ->get()->getRow();
    }

    public function getTotalDiscBySerie(int $idSerie)
    {
        return $this->select('count(*) as total, d.description, d.id')
        //->from('tb_school_schedule h')
        ->join('tb_allocation a', $this->table.'.id_allocation = a.id')
        ->join('tb_teacher_discipline td', 'a.id_teacher_discipline = td.id')
        ->join('tb_discipline d', 'td.id_discipline = d.id')
        ->where($this->table.'.id_series', $idSerie)
        ->where($this->table.'.status', 'A')
        ->groupBy('td.id_discipline')
        ->get()->getResult();


        // SELECT count(*) as total, td.description  FROM tb_school_schedule tss
        // JOIN tb_allocation ta ON tss.id_allocation = ta.id
        // JOIN tb_teacher_discipline ttd ON ta.id_teacher_discipline = ttd.id
        // JOIN tb_discipline td ON ttd.id_discipline = td.id 
        // WHERE tss.id_series = 1
        // GROUP BY ttd.id_discipline ; 


    }
}
