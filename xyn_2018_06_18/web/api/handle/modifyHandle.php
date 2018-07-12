<?php

include_once "../../class/Handle.php";

$handle_id = $_POST['handle_id'];
$handle_rule_name = $_POST['handle_rule_name'];
$handle_type = $_POST['handle_type'];
$handle_value = $_POST['handle_value'];
$handle_cap = $_POST['handle_cap'];
$handle_remark = isset($_POST['handle_remark'])?$_POST['handle_remark']:null;


$Handle = new Handle();

echo $Handle->modifyHandle($handle_id,$handle_rule_name,$handle_type,$handle_value,$handle_cap,$handle_remark);

