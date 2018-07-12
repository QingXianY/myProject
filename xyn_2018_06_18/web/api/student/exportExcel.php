<?php
include_once "../../../config/get_time.php";
include_once "../../class/Student.php";

header("Content-type: text/html;charset=utf-8");
//检查权限 04=导出
require_once("../../../phpexcel/PHPExcel.php");
include("../../../phpexcel/PHPExcel/IOFactory.php");

$class_id = isset($_GET['class_id'])?$_GET['class_id']:null;
$student_name = isset($_GET['stu_name'])?$_GET['stu_name']:null;
$student_parent_name = isset($_GET['stu_parent_name'])?$_GET['stu_parent_name']:null;
$stu_parent_tel = isset($_GET['stu_parent_tel'])?$_GET['stu_parent_tel']:null;

$Student = new Student();

$rs = $Student->getStudentList2($class_id,$student_name,$student_parent_name,$stu_parent_tel);


//创建一个excel对象
$objPHPExcel = new PHPExcel();

// Set properties  设置文件属性
$objPHPExcel->getProperties()->setCreator("ctos")
    ->setLastModifiedBy("ctos")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

//set width  设置表格宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);

//设置水平居中
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('M')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('N')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// set table header content  设置表头名称
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', '学员姓名')
    ->setCellValue('B1', '所属班级')
    ->setCellValue('C1', '家长姓名')
    ->setCellValue('D1', '家长手机号')
    ->setCellValue('E1', '登录密码')
    ->setCellValue('F1', '账户积分')
    ->setCellValue('G1', '最后登录时间');


$rownum=1;
$get_time = new get_time();
//while ($rows_saleinfo=mysql_fetch_assoc($rs_saleinfo))
while($row = $rs -> fetch_assoc())
{
    $rownum++;

    $row['last_login']=$get_time->sec_time_format($row['last_login']);
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $rownum, $row['stu_name']);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $rownum, $row['class_name']);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $rownum, $row['stu_parent']);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $rownum, $row['stu_parent_tel']);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $rownum, $row['stu_password']);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $rownum, $row['stu_integral']);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $rownum, $row['last_login']);

}


$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//  $filename="销售订单".date('Y-m-d');
// Redirect output to a client’s web browser (Excel5)
//  ob_end_clean();//清除缓冲区,避免乱码  
header('Content-Type: application/vnd.ms-excel');
//  header('Content-Disposition: attachment;filename='.$filename);
header('Content-Disposition: attachment;filename="学生信息表.xls"');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
