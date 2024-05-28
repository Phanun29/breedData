<?php
// Include database connection or any necessary files
include "database/db.php";
require 'vendor/autoload.php'; // Include the Composer autoloader

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// Your SQL query to fetch data
$sql = "SELECT * FROM data";
$result = $conn->query($sql);

// Create a new PHPExcel object
require_once 'PHPExcel.php';
$objPHPExcel = new PHPExcel();

// Set properties for the Excel file (optional)
$objPHPExcel->getProperties()->setCreator("Your Name")
    ->setLastModifiedBy("Your Name")
    ->setTitle("Data Export")
    ->setSubject("Data")
    ->setDescription("Data export from your website")
    ->setKeywords("excel php")
    ->setCategory("Data Export");

// Add data from your database query to the Excel file
$rowCount = 1;
while ($row = $result->fetch_assoc()) {
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $rowCount, $row['column1'])
        ->setCellValue('B' . $rowCount, $row['column2'])
        // Add more columns as needed
        ->setCellValue('C' . $rowCount, $row['column3']);
    // Continue for other columns
    $rowCount++;
}

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
