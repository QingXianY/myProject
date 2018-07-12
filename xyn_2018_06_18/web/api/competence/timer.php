<?php

include_once "../../../config/get_time.php";
include_once "../../../config/db_config.php";

$get_time = new get_time();

$timer_sql = "select * from xd_aclass";
$connect= db_config::getInstance();
$conn=$connect->connect_bdb();
$timer_rs=$conn ->query($timer_sql);



echo $get_time->get();

