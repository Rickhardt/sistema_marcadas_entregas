<?php
require_once "cfg/conexion.php";
require_once "crud/crud.php";
include('PHPExcel/Classes/PHPExcel.php');

$info = new crud();

$sup = $_POST['sup'];
$badge = $_POST['badge'];
$fini = $_POST['fini'];
$ffin = $_POST['ffin'];
$totdays = $_POST['tdays'] + 1;


echo 
print_r($totdays);

$columnas = '';
$querycr = '';
$filas = '';
$filascons =  array();
$comparador = array();
$ES = array();

$date = new DateTime($fini);
$j = 1;
$x = 1;

$objPHPExcel	=	new	PHPExcel();

$objPHPExcel->setActiveSheetIndex(0);

$col = 1;


// cadenas para query, columnas y filas 
for ($i = 1; $i <= $totdays; $i++) {
	if ($i > 1) {
		$date->modify('+1 day');
	}

	$cadena = $date->format('d-M');


	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $cadena . "(E)");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $cadena . "(S)");
	$col++;

	

}


// $result_perf = $info->llenar_detalles($sup, $badge, $fini, $ffin, $querycr);










// $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ESTADO');
// $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'EQUIPO');
// $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'LOTE');
// $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'USER');
// $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ULTIMA TRANSACCION');
// $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'DIA');
// $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'HORAS');
// $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'MINUTOS');
// $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'CAPACIDAD');



// $objPHPExcel->getActiveSheet()->getStyle("A1:I1")->getFont()->setBold(true);


// $rowCount =  2;

// foreach ($result_Q as $row) {


// 	 $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, mb_strtoupper($rowCount-1, 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, mb_strtoupper($est, 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, mb_strtoupper($row['EQUIPMENTNAME'], 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, mb_strtoupper($row['LOTNAME'], 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, mb_strtoupper($row['USERNAME'], 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, mb_strtoupper($row['FECHA_IN'], 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, mb_strtoupper($row['TIME_DIFF1'], 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, mb_strtoupper($row['TIME_DIFF'], 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, mb_strtoupper($row['TIME_DIFF2'], 'UTF-8'));
// 	$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, mb_strtoupper($row['CAPACITY'], 'UTF-8'));


// 	$rowCount++;
// }


// $objPHPExcel->getActiveSheet()->getStyle("A1:A" . $rowCount)->getFont()->setBold(true);


$objWriter    =    new PHPExcel_Writer_Excel2007($objPHPExcel);


header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="RESUMEN_ES.xlsx"');
header('Cache-Control: max-age=0'); //no cache
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
