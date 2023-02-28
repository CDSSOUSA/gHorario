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

    public function __construct()
    {
        parent::__construct();
        // $this->ci = & get_instance();
        //         if (!$this->ci->session->userdata('session_id') && !$this->ci->session->userdata('logado')) {
        // //redirect ("administracao/principalcontroller");
        //             redirect("logout");
        //         }
        // $this->ci->load->model("Instituicao_model");
        //$dados = $this->ci->Instituicao_model->getDadosInstituicao()->row();
        //$this->nomeInstituicao = $dados->nomeInstituicao;
        $this->nomeInstituicao = "PREFEITURA MUNICIPAL DE CAMPINA GRANDE - PB \n".
        "SECRETARIA MUNICIPAL DE EDUCAÇÃO \n"."EMEF CEAI ANTONIO MARIZ";
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

    public function Header()
    {
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
        $this->Image(base_url() . "/assets/img/{$this->logoInstituicao}", 15, 10, 45); // importa uma imagem
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
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function SetTextColorHexa($valor)
    {
        $valor = str_replace("#", "", $valor);

        $r = hexdec(substr($valor, 0, 2));
        $g = hexdec(substr($valor, 2, 2));
        $b = hexdec(substr($valor, 4, 2));

        $this->TextColor = sprintf('%.3F %.3F %.3F rg', $r / 255, $g / 255, $b / 255);
        $this->ColorFlag = ($this->FillColor != $this->TextColor);
    }
    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        //Output a cell
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
            //Automatic page break
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation, $this->CurPageSize);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(sprintf('%.3F Tw', $ws * $k));
            }
        }
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $s = '';
        // begin change Cell function
        if ($fill || (int)$border > 0) {
            if ($fill)
                $op = ((int)$border > 0) ? 'B' : 'f';
            else
                $op = 'S';
            if ((int)$border > 1) {
                $s = sprintf(
                    'q %.2F w %.2F %.2F %.2F %.2F re %s Q ',
                    $border,
                    $this->x * $k,
                    ($this->h - $this->y) * $k,
                    $w * $k,
                    -$h * $k,
                    $op
                );
            } else
                $s = sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (is_int(strpos($border, 'L')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'l')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);

            if (is_int(strpos($border, 'T')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            else if (is_int(strpos($border, 't')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);

            if (is_int(strpos($border, 'R')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'r')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);

            if (is_int(strpos($border, 'B')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'b')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
        if (trim($txt) != '') {
            $cr = substr_count($txt, "\n");
            if ($cr > 0) { // Multi line
                $txts = explode("\n", $txt);
                $lines = count($txts);
                for ($l = 0; $l < $lines; $l++) {
                    $txt = $txts[$l];
                    $w_txt = $this->GetStringWidth($txt);
                    if ($align == 'R')
                        $dx = $w - $w_txt - $this->cMargin;
                    elseif ($align == 'C')
                        $dx = ($w - $w_txt) / 2;
                    else
                        $dx = $this->cMargin;

                    $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                    if ($this->ColorFlag)
                        $s .= 'q ' . $this->TextColor . ' ';
                    $s .= sprintf(
                        'BT %.2F %.2F Td (%s) Tj ET ',
                        ($this->x + $dx) * $k,
                        ($this->h - ($this->y + .5 * $h + (.7 + $l - $lines / 2) * $this->FontSize)) * $k,
                        $txt
                    );
                    if ($this->underline)
                        $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
                    if ($this->ColorFlag)
                        $s .= ' Q ';
                    if ($link)
                        $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
                }
            } else { // Single line
                $w_txt = $this->GetStringWidth($txt);
                $Tz = 100;
                if ($w_txt > $w - 2 * $this->cMargin) { // Need compression
                    $Tz = ($w - 2 * $this->cMargin) / $w_txt * 100;
                    $w_txt = $w - 2 * $this->cMargin;
                }
                if ($align == 'R')
                    $dx = $w - $w_txt - $this->cMargin;
                elseif ($align == 'C')
                    $dx = ($w - $w_txt) / 2;
                else
                    $dx = $this->cMargin;
                $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                if ($this->ColorFlag)
                    $s .= 'q ' . $this->TextColor . ' ';
                $s .= sprintf(
                    'q BT %.2F %.2F Td %.2F Tz (%s) Tj ET Q ',
                    ($this->x + $dx) * $k,
                    ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k,
                    $Tz,
                    $txt
                );
                if ($this->underline)
                    $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
                if ($this->ColorFlag)
                    $s .= ' Q ';
                if ($link)
                    $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
            }
        }
        // end change Cell function
        if ($s)
            $this->_out($s);
        $this->lasth = $h;
        if ($ln > 0) {
            //Go to next line
            $this->y += $h;
            if ($ln == 1)
                $this->x = $this->lMargin;
        } else
            $this->x += $w;
    }
}
