<?php

include_once "../../class/Student.php";

$class_id = isset($_GET['class_id'])?$_GET['class_id']:null;
$student_name = isset($_GET['stu_name'])?$_GET['stu_name']:null;
$student_parent_name = isset($_GET['stu_parent_name'])?$_GET['stu_parent_name']:null;
$stu_parent_tel = isset($_GET['stu_parent_tel'])?$_GET['stu_parent_tel']:null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

$Student = new Student();

echo $Student->getStudentList($page,$rows,$class_id,$student_name,$student_parent_name,$stu_parent_tel);

