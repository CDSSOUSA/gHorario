<?php 
namespace App\Libraries;
use setasign\Fpdi\Fpdi;
  
class SchedulePDF extends \FPDF
{
    public $nomeInstituicao;
    public $enderecoInstituicao;
    public $enderecoTlmk;
    public $logoInstituicao;
    public $idOperadorSistema;

    public function __construct() {
         parent::__construct();
        // $this->ci = & get_instance();
//         if (!$this->ci->session->userdata('session_id') && !$this->ci->session->userdata('logado')) {
// //redirect ("administracao/principalcontroller");
//             redirect("logout");
//         }
// $this->ci->load->model("Instituicao_model");
//$dados = $this->ci->Instituicao_model->getDadosInstituicao()->row();
//$this->nomeInstituicao = $dados->nomeInstituicao;
        $this->nomeInstituicao = 'EMEF CEAI ANTONIO MARIZ';
//$this->enderecoInstituicao = $dados->enderecoInstituicao;
        $this->enderecoInstituicao = "RUA MARCELINO PEREIRA DA, R. Yara Cordeiro Rocha - Cruzeiro";
        $this->enderecoInstituicao .= 'Campina Grande - PB - ';
        $this->enderecoInstituicao .= "CEP  58415-483 \n";
        $this->enderecoInstituicao .= "Tel: (83) 3342-2709 - ";
        $this->enderecoInstituicao .= "E-mail: cleberdossnatossousa@gmail.com";

        // $this->idOperadorSistema = $this->ci->session->userdata('nome');
        $this->logoInstituicao = 'PMCG_2022_logo-300x84.png';
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
    }

    public function Header() {
        header('Content-Type: text/html; charset=utf-8');    
        $this->SetFont('Arial', '', 8);
        $textoCabecalho = $this->nomeInstituicao . "\n";
        //$textoCabecalho .= "Fundada em 01.09.1982 - CNPJ 70.097.894/0001-65 \n";
        //$textoCabecalho .= " Registro no 5º Cartório Civil de Registro de Título e Documento, nº 242, Livro, A-2, Fls. 368-371 \n";
        //$textoCabecalho .= "DECLARADA DE UTILIDADE PÚBLICA FEDERAL - Lei 061/07-08-98 \n";
        $textoCabecalho .= $this->enderecoInstituicao . "\n";
        //$textoCabecalho .= $this->enderecoTlmk . "\n";
        $textoCabecalho .= "SISACPA - Sistema de Informação - V01.01.20 \n";
        //$textoCabecalho .= "www.campinagrande.apaebrasil.org.br - apaecampinagrande@gmail.com\n";
        $this->Image(base_url()."/assets/img/{$this->logoInstituicao}", 15, 5, 45); // importa uma imagem
        $this->SetXY(65, 5);
        $this->SetMargins(20, 20, 40, 20);
        $this->MultiCell(0, 4, utf8_decode($textoCabecalho), 0, "L");
        $this->Ln();
    }
    function Footer()
    {
        /* LOCALIDADE */
        $this->Ln(10);
        $this->SetX(25);
        $textoCidade = 'Campina Grande, ' . (strftime(' %d de %B de %Y', strtotime(date('Y-m-d')))) . '.';
        $this->MultiCell(170, 6, utf8_decode($textoCidade), 0, 'R');
        /* FIM */
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}