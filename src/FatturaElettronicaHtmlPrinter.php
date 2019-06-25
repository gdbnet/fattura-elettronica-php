<?php


namespace Gdbnet\FatturaElettronica;

use DOMDocument;
use XSLTProcessor;

/**
 * Class FatturaElettronicaHtmlPrinter
 *
 * @package Gdbnet\FatturaElettronica
 */
class FatturaElettronicaHtmlPrinter implements FatturaElettronicaPrinterInterface
{
    /**
     * @param string $xml
     *
     * @return string
     */
    public function stampa(string $xml)
    {
        $xslDoc = new DOMDocument();
        $xslDoc->load(dirname(__FILE__) . '/../xsl/FoglioStileAssoSoftware.xsl');

        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($xml);

        $proc = new XSLTProcessor();
        $proc->importStylesheet($xslDoc);

        return $proc->transformToXml($xmlDoc);
    }
}