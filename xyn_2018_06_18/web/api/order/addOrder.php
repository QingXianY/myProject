<?php

include_once "../../class/Order.php";

$student_id = $_GET['student_id'];
$product_id = $_GET['product_id'];

$Order=new Order();

echo $Order->addOrder($student_id,$product_id);