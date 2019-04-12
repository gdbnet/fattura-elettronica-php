<?php

namespace Manrix\FatturaElettronica\Tests\Unit\Body;

use Manrix\FatturaElettronica\Body\Allegati;
use Manrix\FatturaElettronica\Body\DatiBeniServizi;
use Manrix\FatturaElettronica\Body\DatiGenerali;
use Manrix\FatturaElettronica\Body\DatiGeneraliDocumento;
use Manrix\FatturaElettronica\Body\DatiPagamento;
use Manrix\FatturaElettronica\Body\DatiVeicoli;
use Manrix\FatturaElettronica\Body\DettaglioLinea;
use Manrix\FatturaElettronica\Body\DettaglioPagamento;
use Manrix\FatturaElettronica\Body\FatturaElettronicaBody;
use PHPUnit\Framework\TestCase;

class TestFatturaElettronicaBody extends TestCase
{
    public function test_class_dati_generali_documento_is_created()
    {
        $datiGeneraliDocumento = new DatiGeneraliDocumento(
            'TD01',
            '2000-01-01',
            '00001'
        );

        $this->assertInstanceOf(DatiGeneraliDocumento::class, $datiGeneraliDocumento);

        return $datiGeneraliDocumento;
    }

    /**
     * @depends test_class_dati_generali_documento_is_created
     * @return DatiGenerali
     */
    public function test_class_dati_generali_is_created(DatiGeneraliDocumento $datiGeneraliDocumento)
    {
        $datiGenerali = new DatiGenerali($datiGeneraliDocumento);

        $this->assertInstanceOf(DatiGenerali::class, $datiGenerali);

        return $datiGenerali;
    }

    public function test_class_dati_beni_servizi_is_created()
    {
        $datiBeniServizi = new DatiBeniServizi();
        $dettaglioLinea = new DettaglioLinea(
            1,
            'test',
            10,
            10,
            22
        );
        $datiBeniServizi->addDettaglioLinea($dettaglioLinea);

        $this->assertInstanceOf(DatiBeniServizi::class, $datiBeniServizi);

        return $datiBeniServizi;
    }

    /**
     * @depends test_class_dati_generali_is_created
     * @depends test_class_dati_beni_servizi_is_created
     * @return FatturaElettronicaBody
     */
    public function test_class_is_created(DatiGenerali $datiGenerali, DatiBeniServizi $datiBeniServizi)
    {
        $fatturaElettronicaBody = new FatturaElettronicaBody($datiGenerali, $datiBeniServizi);

        $this->assertInstanceOf(FatturaElettronicaBody::class, $fatturaElettronicaBody);

        return $fatturaElettronicaBody;
    }

    public function test_class_dati_veicoli_is_created()
    {
        $datiVeicoli = new DatiVeicoli('2000-01-01', '10km');

        $this->assertInstanceOf(DatiVeicoli::class, $datiVeicoli);

        return $datiVeicoli;
    }

    public function test_class_dati_pagamento_is_created()
    {
        $datiPagamento = new DatiPagamento('TP01');
        $dettaglioPagamento = new DettaglioPagamento('MP01', 10);
        $datiPagamento->addDettaglioPagamento($dettaglioPagamento);

        $this->assertInstanceOf(DatiPagamento::class, $datiPagamento);

        return $datiPagamento;
    }

    public function test_class_allegati_is_created()
    {
        $allegati = new Allegati('test.txt', 'test12345');

        $this->assertInstanceOf(Allegati::class, $allegati);

        return $allegati;
    }

    /**
     * @depends test_class_is_created
     * @depends test_class_dati_veicoli_is_created
     * @depends test_class_dati_pagamento_is_created
     * @depends test_class_allegati_is_created
     * @param FatturaElettronicaBody $fatturaElettronicaBody
     * @param DatiVeicoli $datiVeicoli
     * @param DatiPagamento $datiPagamento
     * @param Allegati $allegati
     * @return FatturaElettronicaBody
     * @throws \Manrix\FatturaElettronica\FatturaElettronicaException
     */
    public function test_class_returns_correct_array(
        FatturaElettronicaBody $fatturaElettronicaBody,
        DatiVeicoli $datiVeicoli,
        DatiPagamento $datiPagamento,
        Allegati $allegati
    )
    {
        $fatturaElettronicaBody->addDatiPagamento($datiPagamento)
            ->setDatiVeicoli($datiVeicoli)
            ->addAllegati($allegati);

        $this->assertInstanceOf(FatturaElettronicaBody::class, $fatturaElettronicaBody);

        $array = $fatturaElettronicaBody->toArray();
        $this->assertArrayHasKey('DatiGenerali', $array);
        $this->assertArrayHasKey('DatiBeniServizi', $array);
        $this->assertArrayHasKey('DatiVeicoli', $array);
        $this->assertArrayHasKey('DatiPagamento', $array);
        $this->assertArrayHasKey('Allegati', $array);

        return $fatturaElettronicaBody;
    }

    /**
     * @depends test_class_returns_correct_array
     * @param FatturaElettronicaBody $fatturaElettronicaBody
     * @throws \Manrix\FatturaElettronica\FatturaElettronicaException
     */
    public function test_class_is_created_from_array(FatturaElettronicaBody $fatturaElettronicaBody)
    {
        $array = $fatturaElettronicaBody->toArray();

        $fatturaElettronicaBody = FatturaElettronicaBody::fromArray($array);

        $this->assertInstanceOf(FatturaElettronicaBody::class, $fatturaElettronicaBody);
        $this->assertInstanceOf(DatiGenerali::class, $fatturaElettronicaBody->getDatiGenerali());
        $this->assertInstanceOf(DatiBeniServizi::class, $fatturaElettronicaBody->getDatiBeniServizi());
        $this->assertInstanceOf(DatiVeicoli::class, $fatturaElettronicaBody->getDatiVeicoli());
        $this->assertIsArray($fatturaElettronicaBody->getDatiPagamento());
        $this->assertIsArray($fatturaElettronicaBody->getAllegati());
    }
}