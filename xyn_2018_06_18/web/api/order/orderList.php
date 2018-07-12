<?php

include_once "../../class/Order.php";

$order_code = isset($_GET['order_code'])?$_GET['order_code']:null;
$student_id = isset($_GET['student_id'])?$_GET['student_id']:null;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$start_date = isset($_GET['start_date'])?$_GET['start_date']:null;
$end_date = isset($_GET['end_date'])?$_GET['end_date']:null;

$Order = new Order();


echo $Order->getOrderList($page,$rows,$order_code,$student_id,$start_date,$end_date);



