<?php

namespace App\Controllers\Report\Schedule;

use App\Controllers\BaseController;
use App\Libraries\fpdf\Fpdf;
use App\Libraries\SchedulePDF;
use App\Models\SchoolScheduleModel;

//use FPDF;
//use FPDF2;

class Series extends BaseController
{
    public function series(int $idSerie)
    {
        $LINE_HEIGHT = 15;

        // // initiate PDF
        // $pdf = new \FPDF();

        // // set the source file
        // $pageCount = $pdf->setSourceFile("file-2.pdf");

        // $pdf->AliasNbPages();
        // for ($i=1; $i <= $pageCount; $i++) { 
        //     //import a page then get the id and will be used in the template
        //     $tplId = $pdf->importPage($i);
        //     //create a page
        //     $pdf->AddPage();
        //     //use the template of the imporated page
        //     $pdf->useTemplate($tplId);
        // }


        // //display the generated PDF
        // header('Content-Description: File Transfer');
        // header('Content-Type: application/pdf');
        // readfile($pdf->Output());

        // header('Content-Type: text/html; charset=utf-8');
        // header('Content-type: application/pdf');
        $pdf = new SchedulePDF();
        //header('Content-type: application/pdf');

        $pdf->AddPage('L', 'A4');


        $pdf->AliasNbPages();

        $pdf->SetTitle("OpenGisCRM Report Leads");
        $pdf->SetLeftMargin(15);
        $pdf->SetRightMargin(15);
        $pdf->SetFillColor(200, 200, 200);

        $pdf->SetFont('Arial', 'B', 9);
        //$this->pdf->SetWidths(array(40, 40, 40));

        //$this->pdf->Row(array('f name', 'l name', 'email'));

        //$this->pdf->Row(array('john', 'doe', 'admin@gmail.com'));

        // $pdf->Cell(40, 5, 'Total By Date:', 'TB', 0, 'L', '1');
        // $pdf->Cell(40, 5, date("d-m-y"), 'B', 0, 'L', 0);
        // $pdf->Cell(40, 5, 'By OpenGisCRM :', 'TB', 0, 'L', '1');
        // $pdf->Cell(40, 5, 'https://opengiscrm.com/', 'B', 0, 'L', 0);
        $pdf->Ln(15);
        $serie = '7ºA - MANHÃ :: 2023';

         /* CABECALHO DA TERMO */
         $pdf->SetFont('Courier', 'B', 12);
         $textoTituloFicha = 'QUADRO DE HORÁRIO :: '. $serie;
         $pdf->SetFont('Courier', 'B', 10);
         //$ficha->SetY(80);
         $pdf->SetX(15);
         $pdf->MultiCell(0, 4, utf8_decode($textoTituloFicha), 0, 'L');
         $pdf->Ln(5);

         /* FIM */
 
        //ob_end_clean();
        //ob_get_clean();
        $pdf->Cell(40, $LINE_HEIGHT, 'DIAS/AULAS', 'TBLR', 0, 'C', 1);

        for ($dw = 2; $dw < 7; $dw++) {
            $pdf->Cell(40, $LINE_HEIGHT, diaSemanaExtenso($dw), 'TBLR', 0, 'C', 1);
        }

        $pdf->Ln($LINE_HEIGHT+2);
        
        for ($ps = 1; $ps < 7; $ps++) {
            $pdf->Cell(40, $LINE_HEIGHT, $ps . utf8_decode('ª Aula'), 'TBLR', 0, 'C', 1);
            //$pdf->Ln(6);
            $data = new SchoolScheduleModel();
            $result = $data->geSerieSchedule($idSerie);

            //dd($result);



            //$pdf->Cell(40, 5, $pos, 'TBLR', 0, 'C', 1);
            //dd($result);
            $casa = '';

            for ($dw = 2; $dw < 7; $dw++) {

              

                foreach ($result as $item) {
                    if ($item->position == $ps && $item->dayWeek == $dw) {

                        $casa = $item->abbreviation.' - '. $item->name;
                    }
                    
                }
                //$pdf->SetFillColor(0, 169, 169);
                $pdf->Cell(40, $LINE_HEIGHT, $casa, 1, 0, 'C', 0);
                //$pdf->Cell(40, 5, ' ', 1, 0, 'C', 0);
                $casa = '';
                
                
            }
            //$pdf->SetFillColor(0,0,0);
           

            $pdf->Ln($LINE_HEIGHT);
        }

        //$pdf->Ln(6);

        ob_get_clean();
        $pdf->Output("OpenGisCRM Report leads.pdf", 'I');
        exit;
    }

    
}
