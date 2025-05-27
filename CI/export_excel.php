<?php
require_once 'config.php';
require 'vendor/autoload.php'; // You'll need to install PhpSpreadsheet via Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set title
$sheet->setCellValue('A1', 'COMUNICADO INTERNO (CI)');
$sheet->mergeCells('A1:H1');

// Client Information
$sheet->setCellValue('A3', 'Identificação do Cliente');
$sheet->setCellValue('A4', 'Contrato Nr:');
$sheet->setCellValue('B4', $contrato['idcontrato'] . ' - ' . $contrato['cliente']);
$sheet->setCellValue('A5', 'CNPJ:');
$sheet->setCellValue('B5', $contrato['cnpj']);

// Efetivo Contratado
$sheet->setCellValue('A7', 'Efetivo Contratado');
$sheet->setCellValue('A8', 'Quantidade');
$sheet->setCellValue('B8', 'Cargo/Função');
$sheet->setCellValue('C8', 'Salário');
$sheet->setCellValue('D8', 'Ac Função');
$sheet->setCellValue('E8', 'Escala');
$sheet->setCellValue('F8', 'Período');
$sheet->setCellValue('G8', 'Jornada');
$sheet->setCellValue('H8', 'Intrajornada');

$row = 9;
while ($efetivo = $result_efetivo->fetch_assoc()) {
    $sheet->setCellValue('A'.$row, $efetivo['quantidade']);
    $sheet->setCellValue('B'.$row, $efetivo['cargo']);
    $sheet->setCellValue('C'.$row, $efetivo['salario']);
    $sheet->setCellValue('D'.$row, $efetivo['ac_funcao']);
    $sheet->setCellValue('E'.$row, $efetivo['escala']);
    $sheet->setCellValue('F'.$row, $efetivo['periodo']);
    $sheet->setCellValue('G'.$row, $efetivo['jornada']);
    $sheet->setCellValue('H'.$row, $efetivo['intrajornada']);
    $row++;
}

// Insumos
$row += 2;
$sheet->setCellValue('A'.$row, 'Insumos Utilizados');
$row++;
$sheet->setCellValue('A'.$row, 'Quantidade');
$sheet->setCellValue('B'.$row, 'Insumo');
$sheet->setCellValue('C'.$row, 'Valor Mensal');
$sheet->setCellValue('D'.$row, 'Total R$');

$row++;
while ($insumo = $result_insumos->fetch_assoc()) {
    $sheet->setCellValue('A'.$row, $insumo['quantidade']);
    $sheet->setCellValue('B'.$row, $insumo['insumo']);
    $sheet->setCellValue('C'.$row, $insumo['valor_mensal']);
    $sheet->setCellValue('D'.$row, $insumo['valor_total']);
    $row++;
}

// Observações
$row += 2;
$sheet->setCellValue('A'.$row, 'Observações');
$row++;
$sheet->setCellValue('A'.$row, $contrato['observacoes'] ?? '');

// Set column widths
$sheet->getColumnDimension('A')->setWidth(15);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('C')->setWidth(15);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(15);
$sheet->getColumnDimension('F')->setWidth(15);
$sheet->getColumnDimension('G')->setWidth(15);
$sheet->getColumnDimension('H')->setWidth(15);

// Create Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="CI_'.$idcontrato.'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
