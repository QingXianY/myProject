<?php

include_once "../../class/Student.php";

$student_id = $_POST['student_id'];
$modify_type = $_POST['modify_type'];
$modify_value = $_POST['modify_value'];

$Student = new Student();

echo $Student->modifyStudentIntegral($student_id,$modify_type,$modify_value);

