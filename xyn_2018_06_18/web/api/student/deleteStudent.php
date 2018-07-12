<?php

include_once "../../class/Student.php";

$student_id = $_GET['student_id'];

//$Role = Role::getInstance();
$Student= new Student();
echo $Student->deleteStudent($student_id);