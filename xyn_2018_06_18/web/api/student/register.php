<?php

include_once "../../class/Student.php";

$stu_parent_tel = $_POST['stu_parent_tel'];
$message_code = $_POST['message_code'];
$stu_password = $_POST['stu_password'];

$Student=new Student();

echo $Student->register($stu_parent_tel,$message_code,$stu_password);