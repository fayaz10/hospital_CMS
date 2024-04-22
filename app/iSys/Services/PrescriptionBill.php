<?php

/**
 * User: asifgulistani
 * Date: 3/25/2019
 * Time: 10:13 PM
 */

namespace App\iSys\Services;

use TCPDF;

class PrescriptionBill extends TCPDF
{
    //Page header
    public function Header()
    {
        $image_file = 'img/print-header.png';
        $this->Image($image_file, 0, 0, 210, 30, 'PNG', '', '', true);
    }
    // Page footer
    public function Footersadf() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        // $this->SetFont('dejavusans', '', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        // $this->Cell(0, 10, 'تماس ها : 0777757523 - 0785790890', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // $this->Cell(0, 10, 'آدرس: کابل، چهارراهی سر سبزی، جوار هوتل شام پارس، شفاخانه آریا سیتی.', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}