<?php
ini_set('date.timezone', 'Asia/Shanghai');
// Include the main TCPDF library
require_once('tcpdf.php');
// create a pdf document in memory
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,
                 PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Luke Welling and Laura Thomson');
$pdf->SetTitle('Hello Word (PHP)');
$pdf->SetSubject('Test PDF');
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// set font
$pdf->SetFont('times', '', 24);
//Add a custom size
// add a page
$pdf->AddPage('L', 'LETTER');
$pdf->Bookmark('Page 1', 0, 0);
// pdf_set_text_pos($pdf, 50, 700);
// write text
$pdf->setXY(50, 80);
$pdf->Write(5, 'Hello, World!', '', 0, '', false, 0, false, false, 0);
$pdf->setXY(50,90);
$pdf->Write(5, '(says PHP)', '', 0, '', false, 0, false, false, 0);
$pdf->endPage();
$pdf->Output('testpdf.pdf', 'I');
?>
