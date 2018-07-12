<?php

include_once "../../class/Aclass.php";

$course_id = $_POST['course_id'];
$aclass_name = $_POST['class_name'];
$aclass_head = $_POST['class_head'];
$teacher_arry = $_POST['teacher_arry'];
$teacher_arry=json_decode($teacher_arry,true);
$Aclass=new Aclass();

echo $Aclass->addAclass($course_id,$aclass_name,$aclass_head,$teacher_arry);