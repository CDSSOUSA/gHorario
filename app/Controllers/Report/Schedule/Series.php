<?php

namespace App\Controllers\Report\Schedule;

use App\Controllers\BaseController;
use App\Libraries\fpdf\Fpdf;
use App\Libraries\SchedulePDF;
use App\Models\SchoolScheduleModel;
use App\Models\SeriesModel;
use App\Models\YearSchoolModel;

//use FPDF;
//use FPDF2;

class Series extends BaseController
{
    public function series(int $idSerie)
    {
        $series = new SeriesModel();
        $seriesData = $series->getDescription($idSerie);
     

        $description = $seriesData[0]->description;
        $clasfication = $seriesData[0]->classification;
        $shift = $seriesData[0]->shift;
        $idYearSchool = $seriesData[0]->id_year_school;

        $yearSchool = new YearSchoolModel();
        $year = $yearSchool->getYearById($idYearSchool);
        $yearDescription = $year->description;

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
        $serie = $description.'º'. $clasfication.' - '.turno($shift).' :: '.$yearDescription;

         /* CABECALHO DA TERMO */
         $pdf->SetFont('Courier', 'B', 12);
         $textoTituloFicha = 'QUADRO DE HORÁRIO :: '. $serie;
         $pdf->SetFont('Courier', 'B', 10);
         //$ficha->SetY(80);
         $pdf->SetX(15);
         $pdf->MultiCell(0, 4, utf8_decode($textoTituloFicha), 0, 'L');
         $pdf->Ln(5);
         $pdf->SetTitle(utf8_decode($textoTituloFicha));
         /* FIM */
 
        //ob_end_clean();
        //ob_get_clean();
        $pdf->Cell(40, $LINE_HEIGHT, 'DIAS/AULAS', 'TBLR', 0, 'C', 1);

        for ($dw = 2; $dw < 7; $dw++) {
            $pdf->Cell(40, $LINE_HEIGHT, utf8_decode(diaSemanaExtenso($dw)), 'TBLR', 0, 'C', 1);
        }

        $pdf->Ln($LINE_HEIGHT+2);
        
        for ($ps = 1; $ps < 7; $ps++) {
            $dataTicketAula = $ps."ª Aula \n".translateSchedule($ps,$shift);
            $pdf->Cell(40, $LINE_HEIGHT,  utf8_decode($dataTicketAula), 'TBLR', 0, 'C', 1);
            //$pdf->Ln(6);
            $data = new SchoolScheduleModel();
            $result = $data->geSerieSchedule($idSerie);

            //dd($result);



            //$pdf->Cell(40, 5, $pos, 'TBLR', 0, 'C', 1);
            //dd($result);
            $dataSchedule = '-';

            for ($dw = 2; $dw < 7; $dw++) {

              

                foreach ($result as $item) {
                    if ($item->position == $ps && $item->dayWeek == $dw) {

                        

                        $pdf->SetTextColorHexa($item->color);
                        //$pdf->Image(base_url() . "/assets/img/{$item->icone}", 15, 5, 45); // importa uma imagem
       
                        $dataSchedule = utf8_decode($item->description)."\n".utf8_decode(abbreviationTeacher($item->name));
                       
                    }
                    
                }
                //$pdf->SetFillColor(0, 169, 169);
                $pdf->Cell(40, $LINE_HEIGHT, $dataSchedule, 1, 0, 'C', 0);
                //$pdf->Cell(40, 5, ' ', 1, 0, 'C', 0);
                $pdf->SetTextColor(0,0,0);
                $dataSchedule = '-';
                
                
            }
            //$pdf->SetFillColor(0,0,0);
           

            $pdf->Ln($LINE_HEIGHT);
        }

        //$pdf->Ln(6);

        ob_get_clean();
        $pdf->Output(convert_accented_characters($textoTituloFicha), 'I');
        exit;
    }

    
}
