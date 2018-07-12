<?php

include_once "../../class/Aclass.php";

$Aclass_id = $_POST['class_id'];
$course_id = $_POST['course_id'];
$aclass_name = $_POST['class_name'];
$aclass_head = $_POST['class_head'];
$aclass_date = $_POST['class_date'];

$Aclass=new Aclass();

echo $Aclass->modifyAclass($Aclass_id,$course_id,$aclass_name,$aclass_head,$aclass_date);

