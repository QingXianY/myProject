<?php
include_once "../../../config/db_config.php";
include_once "../../../config/get_time.php";

class Sign{
    private $signList;

    public function __construct(){}

    //获取用户签到列表
    public function getSignList($page,$rows,$student_id,$start_date,$end_date){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();

        $where = "where student_id = '$student_id' ";
        if($start_date){
            $where.= " and sign_date >= '$start_date' ";
        }
        if($end_date){
            $where.= " and sign_date <= '$end_date' ";
        }
        $signList_sql = "select * from xd_sign ".$where." order by sign_date desc"." limit $offset,$rows";  //sql查询语句，根据日期查询
        $signList_rs=$conn ->query($signList_sql);
        $signList=array();
        $signListCount_sql = "select count(*) from xd_sign ".$where;  //sql查询语句，根据角色姓名模糊查询
        $signListCount_rs=$conn ->query($signListCount_sql);
        $row=$signListCount_rs -> fetch_row();
        $count=$row[0];
        while($signList_row = $signList_rs -> fetch_assoc()){
            array_push($signList,$signList_row);
        }
        return $connect -> out_msg2(1,'',$count,$this->signList = $signList);
    }

    //新增签到
    public function addSign($student_id,$sign_flag,$sign_count){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $get_time = new get_time();
        $present = $get_time->get_now_sec();
        $insertSign_sql = "insert into xd_sign(student_id,sign_flag,sign_count,sign_date) VALUE('$student_id','$sign_flag','$sign_count','$present')";
        $conn ->query($insertSign_sql);
        $insertSign_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($insertSign_rs){
            return $connect -> out_msg(1,'新增签到成功!');
        }else{
            return $connect -> out_msg(0,'新增签到失败!');
        }
    }

    //删除签到
    public function deleteSign($rid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteSign_sql = "delete from xd_sign where rid = '$rid'";
        $conn ->query($deleteSign_sql);
        $deleteSign_rs = mysqli_affected_rows($conn);
        $conn -> close();
        if($deleteSign_rs){
            return $connect -> out_msg(1,'删除签到成功!');
        }else{
            return $connect -> out_msg(0,'删除签到失败!');
        }
    }

}



