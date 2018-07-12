<?php

include_once "../../class/Student.php";

$student_id = $_POST['student_id'];
$stu_name = $_POST['stu_name'];
$stu_parent = $_POST['stu_parent'];
$stu_parent_tel = $_POST['stu_parent_tel'];
$stu_password = $_POST['stu_password'];

$Student = new Student();

echo $Student->modifyStudent($student_id,$stu_name,$stu_parent,$stu_parent_tel,$stu_password);

