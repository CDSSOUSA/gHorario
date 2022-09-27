<?php

namespace App\Models;

use CodeIgniter\Model;

class AllocationModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'tb_allocation';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id_teacher_discipline', 'dayWeek', 'position', 'situation', 'status', 'shift', 'id_year_school'];

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

    public function getAllocationByDayWeek(int $id_serie, int $diaSemana, int $posicao, string $shift, $disciplines)
    {

        $result = $this->select('tb_allocation.id,
         p.name, d.abbreviation, pd.color, pd.id_teacher, d.icone')
            ->join('tb_teacher_discipline pd', 'pd.id = tb_allocation.id_teacher_discipline')
            ->join('tb_teacher p', 'p.id = pd.id_teacher')
            ->join('tb_discipline d', 'pd.id_discipline = d.id')
            ->where('tb_allocation.dayWeek', $diaSemana)
            ->where('tb_allocation.status', 'A')
            ->where('tb_allocation.position', $posicao)
            ->where('tb_allocation.shift', $shift)
            ->where('tb_allocation.situation', 'L')
            ->where('tb_allocation.id_year_school', session('session_idYearSchool'))
            ->whereNotIn('pd.id_discipline', $disciplines)
            ->orderBy('p.name')
            ->get()->getResultArray();

        return $result;



        /*SELECT tp.nome FROM tb_teacher_discipline tpd 
            join tb_allocation tap on tpd.id = tap.id_professor
            join tb_professor tp on tp.id = tpd.id_professor
            where tap.dayWeek = 2 AND 
            tap.position = 3 AND 
            tpd.id_serie = 1 AND 
            tap.status = 'A' AND 
            tap.situation = 'L';*/

        //return !is_null($result) ? $result : [];
    }
    public function getAllocationByDayWeekA(int $id_serie, int $diaSemana, int $posicao, string $shift)
    {

        $result = $this->select('tb_allocation.id,
         p.name, d.abbreviation, pd.color, pd.id_teacher, d.icone')
            ->join('tb_teacher_discipline pd', 'pd.id = tb_allocation.id_teacher_discipline')
            ->join('tb_teacher p', 'p.id = pd.id_teacher')
            ->join('tb_discipline d', 'pd.id_discipline = d.id')
            ->where('tb_allocation.dayWeek', $diaSemana)
            ->where('tb_allocation.status', 'A')
            ->where('tb_allocation.position', $posicao)
            ->where('tb_allocation.shift', $shift)
            ->where('tb_allocation.situation', 'L')
            ->where('tb_allocation.id_year_school', session('session_idYearSchool'))
            ->orderBy('p.name')
            ->get()->getResultArray();
        return $result;
    }
    public function getAllocationByDayWeekOcupation(int $id_serie, int $diaSemana, int $posicao, string $shift)
    {

        $result = $this->select('tb_allocation.id,
         p.name, d.abbreviation, pd.color, pd.id_teacher, d.icone')
            ->join('tb_teacher_discipline pd', 'pd.id = tb_allocation.id_teacher_discipline')
            ->join('tb_teacher p', 'p.id = pd.id_teacher')
            ->join('tb_discipline d', 'pd.id_discipline = d.id')
            ->where('tb_allocation.dayWeek', $diaSemana)
            ->where('tb_allocation.status', 'A')
            ->where('tb_allocation.position', $posicao)
            ->where('tb_allocation.shift', $shift)
            ->where('tb_allocation.situation', 'O')
            ->where('tb_allocation.id_year_school', session('session_idYearSchool'))
            ->orderBy('p.name')
            ->get()->getResultArray();
        return $result;
    }

    public function getAllAlocacaoProfessor(int $idTeacher)
    {
        return $this->select($this->table . '.id, ' . $this->table . '.dayWeek, ' . $this->table . '.tb_allocation.position, ' . $this->table . '.tb_allocation.situation, d.abbreviation, pd.color, ' . $this->table . '.tb_allocation.shift')
            ->join('tb_teacher_discipline pd', 'pd.id = ' . $this->table . '.id_teacher_discipline')
            ->join('tb_discipline d', 'd.id = pd.id_discipline')
            ->where('pd.id_teacher', $idTeacher)
            ->where($this->table . '.status', 'A')
            ->where('pd.id_year_school', session('session_idYearSchool'))
            ->where($this->table . '.id_year_school', session('session_idYearSchool'))
            ->orderBy($this->table . '.situation DESC, ' . $this->table . '.shift ASC, ' . $this->table . '.dayWeek ASC, ' . $this->table . '.position ASC')
            ->get()->getResult();
    }
    public function getAllocationTeacher(int $idTeacher)
    {
        return $this->select($this->table . '.id, ' . $this->table . '.dayWeek, ' . $this->table . '.position, ' . $this->table . '.situation, d.abbreviation, pd.color, d.icone, ' . $this->table . '.shift')
            ->join('tb_teacher_discipline pd', 'pd.id = ' . $this->table . '.id_teacher_discipline')
            ->join('tb_discipline d', 'd.id = pd.id_discipline')
            ->where('pd.id_teacher', $idTeacher)
            ->where($this->table . '.status', 'A')
            ->where('pd.id_year_school', session('session_idYearSchool'))
            ->where($this->table . '.id_year_school', session('session_idYearSchool'))
            ->orderBy($this->table . '.situation DESC, ' . $this->table . '.shift ASC, ' . $this->table . '.dayWeek ASC, ' . $this->table . '.position ASC')
            ->get()->getResult();
    }


    public function getTeacherByIdAllocation(int $idAlocacao)
    {
        return $this->select('d.icone, pd.id_teacher, tb_allocation.id_teacher_discipline, pd.color, d.abbreviation,tb_allocation.dayWeek, tb_allocation.position')
            ->join('tb_teacher_discipline pd', 'pd.id = tb_allocation.id_teacher_discipline')
            ->join('tb_discipline d', 'd.id = pd.id_discipline')
            ->where('tb_allocation.id', $idAlocacao)
            ->get()->getResult();
    }

    public function saveAllocation(array $data)
    {
        $shift = $data['shift'];
        $allocation = $data['disciplines'];
        $dayWeek = $data['dayWeek'];
        $position = $data['position'];

        $cont = 0;

        foreach ($shift as $sh) {
            foreach ($allocation as $item) {
                foreach ($dayWeek as $day) {
                    foreach ($position as $posit) {
                        $dataAllocation['id_teacher_discipline'] = $item;
                        $dataAllocation['dayWeek'] = $day;
                        $dataAllocation['position'] = $posit;
                        $dataAllocation['situation'] = 'L';
                        $dataAllocation['status'] = 'A';
                        $dataAllocation['shift'] = $sh;
                        $dataAllocation['id_year_school'] = session('session_idYearSchool');;
                        if ($this->validateAllocation($item, $day, $posit, $sh) <= 0) {
                            $save = $this->save($dataAllocation);
                            if ($save) {
                                $cont++;
                            }
                        }
                    }
                }
            }
        }

        if ($cont >= 1) {
            return true;
        }

        return false;
    }

    public function getCountByIdTeacDiscOcupation(int $id_teacher_discipline)
    {
        return $this->where('id_teacher_discipline', $id_teacher_discipline)
            ->where('situation', 'O')
            ->where('status', 'A')
            ->where('id_year_school', session('session_idYearSchool'))
            ->countAllResults();
    }
    public function getCountByIdTeacDisc(int $id_teacher_discipline)
    {
        return $this->where('id_teacher_discipline', $id_teacher_discipline)
            //->where('situation','O')
            ->where('status', 'A')
            ->where('id_year_school', session('session_idYearSchool'))
            ->countAllResults();
    }

    private function validateAllocation(int $idTeacherDiscipline, int $dayWeek, int $position, string $shift): int
    {

        return $this->where('id_teacher_discipline', $idTeacherDiscipline)
            ->where('dayWeek', $dayWeek)
            ->where('position', $position)
            ->where('shift', $shift)
            ->where('status', 'A')
            ->where('id_year_school', session('session_idYearSchool'))
            ->countAllResults();
    }
}
