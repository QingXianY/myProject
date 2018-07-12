<?php

include_once "../../../config/db_config.php";
class SignRule{
    private $signRuleList;

    public function __construct(){}

    //检查添加打卡规则重复
    public function selectSignRuleByCount($sign_count){
        $selectSignRule_sql = "select * from xd_signRule where sign_count = '$sign_count'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectSignRule_rs=$conn ->query($selectSignRule_sql);
        return $selectSignRule_row = $selectSignRule_rs -> fetch_assoc();
    }

    //检查修改打卡规则重复
    public function selectSignRuleById($signRule_id){
        $selectSignRule_sql = "select * from xd_signRule where signRule_id = '$signRule_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectSignRule_rs=$conn ->query($selectSignRule_sql);
        return $selectSignRule_row = $selectSignRule_rs -> fetch_assoc();
    }

    //获取打卡规则列表
    public function getSignRuleList(){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $signRuleList_sql = "select * from xd_signRule ";  //sql查询语句，根据打卡规则姓名模糊查询
        $signRuleList_rs=$conn ->query($signRuleList_sql);
        $conn -> close();
        $signRuleList=array();
        while($signRuleList_row = $signRuleList_rs -> fetch_assoc()){
            array_push($signRuleList,$signRuleList_row);
        }
        return $connect -> out_msg(1,'',$this->signRuleList = $signRuleList);
    }

    //新增打卡规则
    public function addSignRule($sign_count,$extra_integral,$rule_remark){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        if($this->selectSignRuleByCount($sign_count)){
            return $connect -> out_msg(2,'打卡次数不能重复!');
        }else{
            $insertSignRule_sql = "insert into xd_signRule(sign_count,extra_integral,rule_remark) VALUE('$sign_count','$extra_integral','$rule_remark')";
            $conn ->query($insertSignRule_sql);
            $insertSignRule_rs=mysqli_affected_rows($conn);
            $conn -> close();
            if($insertSignRule_rs){
                return $connect -> out_msg(1,'新增打卡规则成功!');
            }else{
                return $connect -> out_msg(0,'新增打卡规则失败!');
            }
        }
    }

    //修改打卡规则
    public function modifySignRule($signRule_id,$sign_count,$extra_integral,$rule_remark){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        //修改商品名称时，不能改为除自身外已有商品名称
        if($this->selectSignRuleByCount($sign_count)&&$this->selectSignRuleById($signRule_id)['sign_count'] != $sign_count){
            return $connect -> out_msg(2,'打卡规则已存在!');
        }else{
            $updateSignRule_sql = "update xd_signRule set sign_count = '$sign_count',extra_integral='$extra_integral',rule_remark='$rule_remark' where signRule_id = '$signRule_id' ";
            $conn ->query($updateSignRule_sql);
            $updateSignRule_rs=mysqli_affected_rows($conn);
            $conn -> close();
            if($updateSignRule_rs){
                return $connect -> out_msg(1,'更新打卡规则成功!');
            }else{
                return $connect -> out_msg(0,'更新打卡规则失败!');
            }
        }
    }

    //删除打卡规则
    public function deleteSignRule($signRule_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteSignRule_sql = "delete from xd_signRule where signRule_id = '$signRule_id'";
        $conn ->query($deleteSignRule_sql);
        $deleteSignRule_rs = mysqli_affected_rows($conn);
        if($deleteSignRule_rs){
            return $connect -> out_msg(1,'删除打卡规则成功!');
        }else{
            return $connect -> out_msg(0,'删除打卡规则失败!');
        }
        $conn -> close();
    }

}



