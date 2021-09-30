<?php
$marcsi = json_decode($_POST['marcsi'], true);




include('PHPExcel/Classes/PHPExcel.php');

$objPHPExcel    =    new    PHPExcel();


$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'REG#');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'BADGE');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'NOMBRE');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'TURNO');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'AREA');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'SUPERVISOR');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'OBSERVACION');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'NOTAS');
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'FECHA_INICIO');
$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'FECHA_FINAL');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'HORA_INICIAL');
$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'HORA-FINAL');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'DIAS');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'HORAS');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'MINS');
$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'AJUSTE');
$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'ESTADO');
$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'FECHA_REVISION');


$objPHPExcel->getActiveSheet()->getStyle("A1:R1")->getFont()->setBold(true);


$rowCount    =    2;

foreach ($marcsi as $row) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['IDREG']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['OPERARIO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['NOMBRE']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['TURNO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['AREA']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['SUPERVISOR']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['OBSERVACION']);
    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row['NOTAS']);
    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row['FECHA_INGRESO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row['FECHA_FINAL']);
    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row['HINI']);
    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row['HFIN']);
    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row['NUMERO_DIAS']);
    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row['NUMERO_HORAS']);
    $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row['NUMERO_MINUTOS']);
    $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $row['AJUSTE']);
    $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row['ESTADO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row['FECHA_REVISION']);

    $rowCount++;
}

$objWriter    =    new PHPExcel_Writer_Excel5($objPHPExcel);

ob_start();
$objWriter->save("php://output");
$xlsData = ob_get_contents();
ob_end_clean();

$opResult = array(
    'status' => 1,
    'data' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
);

echo json_encode($opResult);
