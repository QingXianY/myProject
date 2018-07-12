<?php

include_once "../../class/SignRule.php";

$signRule_id = $_GET['signRule_id'];


$SignRule = new SignRule();

echo $SignRule->deleteSignRule($signRule_id);