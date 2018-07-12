<?php

include_once "../../class/Handle.php";

$handle_id = $_GET['handle_id'];


$Handle = new Handle();

echo $Handle->deleteHandle($handle_id);