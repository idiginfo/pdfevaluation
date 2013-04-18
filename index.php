<?php

ini_set('display_errors', '1');

require_once('lib/pdf2xml.php');

require_once('../test/kint/Kint.class.php');

$pdf2xml = new pdf2xml('A Prospective Study ofDepression Following Combat Deployment in Support of the wars in iraq and afghanistan.pdf');

$count = $pdf2xml->exec();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>PDF2XML - PHP Reference Counter</title>
    </head>
    <body>
        <h1>PDF2XML - PHP Reference Counter</h1>
        <?php foreach($count as $x):?>
            <h3>
            <?php echo $x['filename']; ?>
            </h3>
            <p>
            PDFx = <?php echo $x['pdfx']; ?>
            </p>
            <p>
            pdf-extract = <?php echo $x['pdfextract']; ?>
            </p>
            <p>
            scholar2text = <?php echo $x['scholar2text']; ?>
            </p>
        <?php endforeach;?>
    </body>
</html>