<?php

include_once "../../class/Aclass.php";

$course_id = isset($_GET['course_id'])?$_GET['course_id']:null;
$aclass_name = isset($_GET['class_name'])?$_GET['class_name']:null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['limit']) ? intval($_GET['limit']) : 10;


$Aclass = new Aclass();


echo $Aclass->getAclassList($page,$rows,$course_id,$aclass_name);



