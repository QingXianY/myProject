<?php

include_once "../../class/SignRule.php";

$sign_count = $_POST['sign_count'];
$extra_integral = $_POST['extra_integral'];
$rule_remark = $_POST['rule_remark'];

$SignRule = new SignRule();

echo $SignRule->addSignRule($sign_count,$extra_integral,$rule_remark);

