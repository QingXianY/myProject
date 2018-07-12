<?php

include_once "../../class/Sign.php";

$student_id = $_POST['student_id'];
$sign_flag = $_POST['sign_flag'];
$sign_count = $_POST['sign_count'];



$Sign=new Sign();

echo $Sign->addSign($student_id,$sign_flag,$sign_count);