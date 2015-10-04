<?php
ini_set('date.timezone', 'Asia/Shanghai');
// Include the main TCPDF library
require_once('tcpdf.php');
// create short variable names
$name = $_POST['name'];
$score = $_POST['score'];
if(!$name || !$score) {
    echo '<h1>Error:</h1><p>This page was called incorrectly</p>';
    exit();
} else {
    $date = date('Y-m-d');
    // create a pdf document in memory
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,
        PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set font
    $font = 'times';
    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    // set up name of font for later use
    // set up the page size in points and create page
    // US letter is 11" x 8.5" and there are approximately 72 points per inch
    $width = 11*72;
    $height = 8.5*72;
    $resolution= array($width, $height);
    $pdf->AddPage('L', $resolution);
    // draw our borders
    $inset = 20; // space between border and page edge
    $border = 10; // width of main border line
    $inner = 2; // gap within the border
    //draw outer border
    $pdf->SetLineWidth(1.0);
    $pdf->Rect($inset-$inner,
        $inset-$inner,
        $width-2*($inset-$inner),
        $height-2*($inset-$inner));
    //draw main border $border points wide
    $pdf->SetLineWidth($border);
    $pdf->Rect($inset+$border/2,
        $inset+$border/2,
        $width-2*($inset+$border/2),
        $height-2*($inset+$border/2));
    $pdf->SetLineWidth(1.0);
    // draw inner border
    $pdf->Rect($inset+$border+$inner,
        $inset+$border+$inner,
        $width-2*($inset+$border+$inner),
        $height-2*($inset+$border+$inner));
    // add heading
    $h = 590;
    $pdf->SetFont($font, '', 128);
    $startx = ($width - $pdf->GetStringWidth('PHP Certification', $font, '', 12))/2;
    $pdf->SetAbsXY($startx, $h-510);
    $pdf->Write(20, 'PHP Certification');
    // add text
    $pdf->SetFont($font, '', 72);
    $startx = 70;
    $pdf->SetAbsXY($startx, $h-430);
    $pdf->Write(5, 'This is to certify that:');
    $pdf->SetAbsXY($startx+90, $h-391);
    $pdf->Write(5, strtoupper($name));

    $pdf->SetFont($font, '', 56);
    $pdf->SetAbsXY($startx, $h-340);
    $pdf->Write(5, 'has demonstrated that they are certifiable '.
                'by passing a rigorous exam');
    $pdf->SetAbsXY($startx, $h-310);
    $pdf->Write(5, 'consisting of three multiple choice questions.');
    $pdf->SetAbsXY($startx, $h-260);
    $pdf->Write(5, "$name obtained a score of $score".'%.');
    $pdf->SetAbsXY($startx, $h-210);
    $pdf->Write(5, 'The test was set and overseen by the ');
    $pdf->SetAbsXY($startx, $h-180);
    $pdf->Write(5, 'Fictional Institute of PHP Certification');
    $pdf->SetAbsXY($startx, $h-150);
    $pdf->Write(5, "on $date.");
    $pdf->SetAbsXY($startx, $h-100);
    $pdf->Write(5, 'Authorised by:');

    // add bitmap signature image
    $signature = 'signature.png';
    $pdf->Image($signature, 200, $h-100, 170, 50);
    // set clolr
    $fillblue = array(0, 0, 128);
    // draw ribbon 1
    $pdf->PolyLine(array(630, $h-150,
                   610, $h-55,
                   632, $h-69,
                   646, $h-49,
                   666, $h-150)
                   ,'DF', array(), $fillblue);
    // draw ribbon 2
    $pdf->PolyLine(array(660, $h-150,
                   680, $h-49,
                   695, $h-69,
                   716, $h-55,
                   696, $h-150)
                   ,'DF', array(), $fillblue);
    $fillred = array(208, 0, 0);
    // draw rosette
    $pdf->StarPolygon(665, $h-175, 57, 32, 9, 0, false,
                     'F', array(), $fillred);
    $pdf->Circle(665, $h-175, 51, 0, 360, 'D');
    // output the pdf
    $pdf->Output('test.pdf', 'I');
}
?>
