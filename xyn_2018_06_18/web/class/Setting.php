<?php

include_once "../../../config/db_config.php";
class Setting{

    protected static $setting;

    public function __construct(){}

    public function selectSetting(){
        $selectSetting_sql = "select * from xd_setting where setting_id = 1";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectSetting_rs=$conn ->query($selectSetting_sql);
        $conn -> close();
        return $connect -> out_msg(1,'',$selectSetting_row = $selectSetting_rs -> fetch_assoc());
    }

    public function modifySetting($lunbo_pic,$adv_info,$adv_content,$kefu_tel,$about_us){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $updateSetting_sql = "update xd_setting set lunbo_pic = '$lunbo_pic',adv_info = '$adv_info',adv_content='$adv_content',kefu_tel='$kefu_tel',about_us='$about_us' where setting_id = 1 ";
        $conn ->query($updateSetting_sql);
        $updateSetting_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($updateSetting_rs){
            return $connect -> out_msg(1,'更新商品成功!');
        }else{
            return $connect -> out_msg(0,'更新商品失败!');
        }
    }



}



