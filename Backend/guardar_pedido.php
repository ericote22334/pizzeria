<?php
session_start();
require('../fpdf/fpdf.php');

$pedido = json_decode($_POST['pedido'], true);
$total = $_POST['total'];

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Pedido - Pizzeria',0,1);

$pdf->SetFont('Arial','',12);

foreach ($pedido as $item) {
    $pdf->Cell(0,8, $item['nombre'] . " - $" . $item['precio'], 0, 1);
}

$pdf->Ln(5);
$pdf->Cell(0,10,"Total: $" . $total,0,1);

$pdf->Output();
?>