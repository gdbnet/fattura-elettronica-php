<?php


namespace Gdbnet\FatturaElettronica;

use Dompdf\Dompdf;

/**
 * Class FatturaElettronicaPdfPrinter
 *
 * @package Gdbnet\FatturaElettronica
 */
class FatturaElettronicaPdfPrinter implements FatturaElettronicaPrinterInterface
{

    /**
     * @param string $xml
     *
     * @return mixed
     */
    public function stampa(string $xml)
    {
        $htmlPrinter = new FatturaElettronicaHtmlPrinter();
        $html = $htmlPrinter->stampa($xml);

        $pdf = new Dompdf();

        $pdf->loadHtml($html);

        $pdf->setPaper('A4', 'porttrait');

        $pdf->render();

        $pdf->stream();

        return true;
    }
}