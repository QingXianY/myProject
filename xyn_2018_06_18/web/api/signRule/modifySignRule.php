<?php

include_once "../../class/SignRule.php";

$signRule_id = $_POST['signRule_id'];
$sign_count = $_POST['sign_count'];
$extra_integral = $_POST['extra_integral'];
$rule_remark = $_POST['rule_remark'];

$SignRule = new SignRule();

echo $SignRule->modifySignRule($signRule_id,$sign_count,$extra_integral,$rule_remark);

