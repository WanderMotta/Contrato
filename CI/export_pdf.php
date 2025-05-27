<?php
ob_start(); // Start output buffering
require_once 'config.php';
require 'vendor/autoload.php';

use TCPDF as TCPDF;

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$idcontrato = $conn->real_escape_string($_GET['id']);

// Fetch data
$query_contrato = "SELECT * FROM view_contratos WHERE idcontrato = '$idcontrato' AND ativo = 'Sim' LIMIT 1";
$result_contrato = $conn->query($query_contrato);
$contrato = $result_contrato->fetch_assoc();

$query_efetivo = "SELECT * FROM view_efetivo_previsto WHERE idcontrato = '$idcontrato'";
$result_efetivo = $conn->query($query_efetivo);

$query_insumos = "SELECT * FROM view_rel_insumos_contratos WHERE idcontrato = '$idcontrato'";
$result_insumos = $conn->query($query_insumos);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistema CI');
$pdf->SetTitle('Comunicado Interno (CI)');

// Set default header data
$pdf->SetHeaderData('', 0, 'COMUNICADO INTERNO (CI)', '');

// Set margins
$pdf->SetMargins(15, 15, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Client Information
$pdf->Cell(0, 10, 'Identificação do Cliente', 0, 1, 'L');
$pdf->Cell(30, 10, 'Contrato Nr:', 0, 0, 'L');
$pdf->Cell(0, 10, $contrato['idcontrato'] . ' - ' . $contrato['cliente'], 0, 1, 'L');
$pdf->Cell(30, 10, 'CNPJ:', 0, 0, 'L');
$pdf->Cell(0, 10, $contrato['cnpj'], 0, 1, 'L');
$pdf->Ln(5);

// Efetivo Contratado
$pdf->Cell(0, 10, 'Efetivo Contratado', 0, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);

// Table header
$header = array('Qtd', 'Cargo/Função', 'Salário', 'Ac Função', 'Escala', 'Período', 'Jornada', 'Intrajornada');
$w = array(15, 40, 25, 25, 25, 25, 20, 25);

foreach($header as $i => $col) {
    $pdf->Cell($w[$i], 7, $col, 1, 0, 'C');
}
$pdf->Ln();

// Table data
$pdf->SetFont('helvetica', '', 10);
while ($efetivo = $result_efetivo->fetch_assoc()) {
    $pdf->Cell($w[0], 6, $efetivo['quantidade'], 1, 0, 'C');
    $pdf->Cell($w[1], 6, $efetivo['cargo'], 1, 0, 'L');
    $pdf->Cell($w[2], 6, $efetivo['salario'], 1, 0, 'R');
    $pdf->Cell($w[3], 6, $efetivo['ac_funcao'], 1, 0, 'R');
    $pdf->Cell($w[4], 6, $efetivo['escala'], 1, 0, 'C');
    $pdf->Cell($w[5], 6, $efetivo['periodo'], 1, 0, 'C');
    $pdf->Cell($w[6], 6, $efetivo['jornada'], 1, 0, 'C');
    $pdf->Cell($w[7], 6, $efetivo['intrajornada'], 1, 0, 'C');
    $pdf->Ln();
}
$pdf->Ln(5);

// Insumos
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Insumos Utilizados', 0, 1, 'L');
$pdf->SetFont('helvetica', 'B', 10);

// Table header
$header = array('Quantidade', 'Insumo', 'Valor Mensal', 'Total R$');
$w = array(25, 85, 40, 40);

foreach($header as $i => $col) {
    $pdf->Cell($w[$i], 7, $col, 1, 0, 'C');
}
$pdf->Ln();

// Table data
$pdf->SetFont('helvetica', '', 10);
$total_qtde = 0;
$total_vr_mensal = 0;
$total_vr_total = 0;

while ($insumo = $result_insumos->fetch_assoc()) {
    $pdf->Cell($w[0], 6, $insumo['qtde'], 1, 0, 'R');
    $pdf->Cell($w[1], 6, $insumo['insumo'], 1, 0, 'L');
    $pdf->Cell($w[2], 6, number_format($insumo['Vr Mensal'], 2, ',', '.'), 1, 0, 'R');
    $pdf->Cell($w[3], 6, number_format($insumo['Vr Total'], 2, ',', '.'), 1, 0, 'R');
    $pdf->Ln();
    
    // Accumulate totals
    $total_qtde += $insumo['qtde'];
    $total_vr_mensal += $insumo['Vr Mensal'];
    $total_vr_total += $insumo['Vr Total'];
}

// Add total row with a different background
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell($w[0], 6, number_format($total_qtde, 0, ',', '.'), 1, 0, 'R', true);
$pdf->Cell($w[1], 6, 'TOTAL', 1, 0, 'R', true);
$pdf->Cell($w[2], 6, number_format($total_vr_mensal, 2, ',', '.'), 1, 0, 'R', true);
$pdf->Cell($w[3], 6, number_format($total_vr_total, 2, ',', '.'), 1, 0, 'R', true);
$pdf->Ln();

$pdf->Ln(5);

// Observações
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, 'Observações', 0, 1, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 5, $contrato['observacoes'] ?? '', 0, 'L');

// Output PDF
$pdf->Output('CI_'.$idcontrato.'.pdf', 'D');
