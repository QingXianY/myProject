<?php

include_once "../../class/Sign.php";


$student_id = $_GET['student_id'];

$start_date = isset($_GET['start_date'])?$_GET['start_date']:null;
$end_date = isset($_GET['end_date'])?$_GET['end_date']:null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

$Sign = new Sign();
echo $Sign->getSignList($page,$rows,$student_id,$start_date,$end_date);

