<?php

include_once "../../class/Setting.php";

$lunbo_pic = $_POST['lunbo_pic'];
$adv_info = $_POST['adv_info'];
$adv_content = $_POST['adv_content'];
$kefu_tel = $_POST['kefu_tel'];
$about_us = $_POST['about_us'];

$Setting = new Setting();

echo $Setting->modifySetting($lunbo_pic,$adv_info,$adv_content,$kefu_tel,$about_us);

