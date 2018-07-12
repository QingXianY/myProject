<?php

include_once "../../../config/db_config.php";
class Handle{
    private $handleList;

    public function __construct(){}

    //检查添加打卡规则重复
    public function selectHandleByCount($sign_count){
        $selectHandle_sql = "select * from xd_handle where sign_count = '$sign_count'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectHandle_rs=$conn ->query($selectHandle_sql);
        return $selectHandle_row = $selectHandle_rs -> fetch_assoc();
    }

    //检查修改打卡规则重复
    public function selectHandleById($handle_id){
        $selectHandle_sql = "select * from xd_handle where handle_id = '$handle_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectHandle_rs=$conn ->query($selectHandle_sql);
        return $selectHandle_row = $selectHandle_rs -> fetch_assoc();
    }

    //获取打卡规则列表
    public function getHandleList(){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $handleList_sql = "select * from xd_handle ";  //sql查询语句，根据打卡规则姓名模糊查询
        $handleList_rs=$conn ->query($handleList_sql);
        $conn -> close();
        $handleList=array();
        while($handleList_row = $handleList_rs -> fetch_assoc()){

            array_push($handleList,$handleList_row);

        }
        return $connect -> out_msg(1,'',$this->handleList = $handleList);
    }

    //新增打卡规则
    public function addHandle($handle_rule_name,$handle_type,$handle_value,$handle_cap,$handle_remark){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $insertHandle_sql = "insert into xd_handle(handle_rule_name,handle_type,handle_value,handle_cap,handle_remark) VALUE('$handle_rule_name','$handle_type','$handle_value','$handle_cap','$handle_remark')";
        $conn ->query($insertHandle_sql);
        $insertHandle_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($insertHandle_rs){
            return $connect -> out_msg(1,'新增打卡规则成功!');
        }else{
            return $connect -> out_msg(0,'新增打卡规则失败!');
        }
    }

    //修改打卡规则
    public function modifyHandle($handle_id,$handle_rule_name,$handle_type,$handle_value,$handle_cap,$handle_remark){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        if($handle_value>$handle_cap){
            return $connect -> out_msg(2,'设置的分值上限不可大于单次分值!');
        }
        //修改商品名称时，不能改为除自身外已有商品名称
        $updateHandle_sql = "update xd_handle set handle_rule_name = '$handle_rule_name',handle_type='$handle_type' ".
        " ,handle_value='$handle_value',handle_cap='$handle_cap',handle_remark = '$handle_remark' where handle_id = '$handle_id' ";
        $conn ->query($updateHandle_sql);
        $updateHandle_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($updateHandle_rs){
            return $connect -> out_msg(1,'更新打卡规则成功!');
        }else{
            return $connect -> out_msg(0,'更新打卡规则失败!');
        }
    }

    //删除打卡规则
    public function deleteHandle($handle_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteHandle_sql = "delete from xd_handle where handle_id = '$handle_id'";
        $conn ->query($deleteHandle_sql);
        $deleteHandle_rs = mysqli_affected_rows($conn);
        if($deleteHandle_rs){
            return $connect -> out_msg(1,'删除打卡规则成功!');
        }else{
            return $connect -> out_msg(0,'删除打卡规则失败!');
        }
        $conn -> close();
    }
}



