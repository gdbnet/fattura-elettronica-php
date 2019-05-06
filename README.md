# fattura-elettronica-php

A PHP package to read and write the xml of italian electronic invoice.

    composer require manrix/fattura-elettronica-php

## Usage

Write the xml:

    $fattura = new FatturaElettronica($header, $body);
    $writer = new FatturaElettronicaXmlWriter($fattura);
    $xml = $writer->encodeXml();

Read the xml:
    
    $xml = '<?xml...';
    $reader = new FatturaElettronicaXmlReader();
    $fattura = $reader->decodeXml($xml);
    
Validate the xml using the xsd:
    
    $xml = '<?xml...';
    $validator = new XmlValidator();
    if ($validator->validate($xml)) {
        echo 'valid xml';
    } else {
        var_dump($validator->getErrors());
    }
    
## Credits

Inspired by `advinser/php-fattura-elettronica-xml`

Xml validation by `deved/fattura-elettronica`