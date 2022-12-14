<?php

namespace App\Models;

use CodeIgniter\Model;

class AlocacaoModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'tb_alocacao_professor';
    protected $primaryKey           = 'id';
    protected $allowedFields = ['id_professor', 'dia_semana', 'posicao_aula', 'status', 'situacao'];
    //protected $returnType           = 'array';

    /**
     * [Description for getAllAlocacaoProfessor]
     *
     * @param int $idProfessor
     * 
     * @return array
     * 
     */
    public function getAllAlocacaoProfessor(int $idProfessor): array
    {
        return $this->select('tb_alocacao_professor.id, pd.id_serie, tb_alocacao_professor.dia_semana, tb_alocacao_professor.posicao_aula, tb_alocacao_professor.situacao')
            ->join('tb_professor_disciplina pd', 'pd.id = tb_alocacao_professor.id_professor')
            ->where('pd.id_professor', $idProfessor)
            ->where('tb_alocacao_professor.status', 'A')
            ->get()->getResultArray();
    }
    public function getAlocacaoProfessor(int $id_serie, int $diaSemana, int $posicao)
    {

        return $result = $this->select('tb_alocacao_professor.id, p.nome, d.descricao')
            ->join('tb_professor_disciplina pd', 'pd.id = tb_alocacao_professor.id_professor')
            ->join('tb_professor p', 'p.id = pd.id_professor')
            ->join('tb_disciplina d', 'pd.id_disciplina = d.id')
            ->where('tb_alocacao_professor.dia_semana', $diaSemana)
            ->where('tb_alocacao_professor.status', 'A')
            ->where('tb_alocacao_professor.posicao_aula', $posicao)
            ->where('pd.id_serie', $id_serie)
            ->where('tb_alocacao_professor.situacao', 'L')
            ->get()->getResultArray();



        /*SELECT tp.nome FROM tb_professor_disciplina tpd 
            join tb_alocacao_professor tap on tpd.id = tap.id_professor
            join tb_professor tp on tp.id = tpd.id_professor
            where tap.dia_semana = 2 AND 
            tap.posicao_aula = 3 AND 
            tpd.id_serie = 1 AND 
            tap.status = 'A' AND 
            tap.situacao = 'L';*/

        //return !is_null($result) ? $result : [];
    }

    public function atualizarHorario($id_professor, $dia_semana, $posicao_aula, $id_serie)
    {
        $result = $this->where('id_professor', $id_professor)
            ->where('dia_semana', $dia_semana)
            ->where('posicao_aula', $posicao_aula)
            ->where('id_serie', $id_serie)
            ->set('situacao', 0)
            ->update();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getProfessorIdAlocacao(int $idAlocacao)
    {
        return $this->select('pd.id_professor')
            ->join('tb_professor_disciplina pd', 'pd.id = tb_alocacao_professor.id_professor')
            ->where('tb_alocacao_professor.id', $idAlocacao)
            ->get()->getRowArray();
    }

    public function excluir(int $idAlocacao)
    {
        $result = $this->where('id', $idAlocacao)
            ->delete();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function salvar(array $data)
    {
        foreach ($data['diaSemana'] AS $item){
             $dataEnd['id_professor'] = $data['idProfessor'];
             $dataEnd['dia_semana'] = $item;
             $dataEnd['posicao_aula'] = 1;
        }

        //$this->save($dataEnd);
    }
}
