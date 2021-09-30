<?php
$marcsi = json_decode($_POST['marcsi'], true);
$marcno = json_decode($_POST['marcno'], true );



include('PHPExcel/Classes/PHPExcel.php');

$objPHPExcel    =    new    PHPExcel();


$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'BADGE');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'OPERADORA');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'PUESTO');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'AREA');
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ESTADO');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'HORA');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'TURNO');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'SUPERVISOR');

$objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setBold(true);


$rowCount    =    2;

foreach ($marcsi as $row) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['BADGE']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['NOMBRE_TRABAJADOR']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['PUESTO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['AREA']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['ESTADO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['HORA']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['TURNO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row['supervisor']);

    $rowCount++;
}

foreach ($marcno as $row) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['BADGE']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['NOMBRE_TRABAJADOR']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['PUESTO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['AREA']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['ESTADO']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['HORA']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['TURNO']);
    // $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row['supervisor']);
    

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
