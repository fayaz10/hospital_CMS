<?php

/**
 * User: asifgulistani
 * Date: 3/25/2019
 * Time: 10:13 PM
 */

namespace App\iSys\Services;

use TCPDF;

class ExperimentBill extends TCPDF
{
    //Page header
    public function Header()
    {
        $image_file = 'img/print-header.png';
        $this->Image($image_file, 0, 0, 210, 30, 'PNG', '', '', true);
    }

}
