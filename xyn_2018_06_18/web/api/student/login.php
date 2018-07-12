<?php

include_once "../../class/Student.php";

$stu_parent_tel = $_POST['stu_parent_tel'];
$stu_password = $_POST['stu_password'];

$Student=new Student();

echo $Student->login($stu_parent_tel,$stu_password);