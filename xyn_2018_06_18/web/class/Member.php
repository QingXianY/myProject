<?php

include_once "../../../config/db_config.php";
class Member{
    private $memberList;
    protected static $member;

    public function __construct(){}

    public function selectMemberById($mid){
        $selectMember_sql = "select * from xd_member where member_id = '$mid'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectMember_rs=$conn ->query($selectMember_sql);
        return $selectMember_row = $selectMember_rs -> fetch_assoc();
    }
    //根据成员角色查询
    public function getMemberList($page,$rows,$mid,$rid,$member_name,$member_tel){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";
        if($rid){
            $where.= " and rid = '$rid'";
        }
        if($mid){
            $where.= " and mid = '$mid'";
        }
        if($member_tel){
            $where.= " and member_tel= '$member_tel'";
        }
        if($member_name){
            $where.= " and member_name like '%$member_name%'";
        }
        $memberList_sql = "select * from xd_member ".$where." limit $offset,$rows";
        $memberList_rs=$conn ->query($memberList_sql);
        $memberListCount_sql = "select count(*) from xd_member ".$where;  //sql查询语句，根据角色姓名模糊查询
        $memberListCount_rs=$conn ->query($memberListCount_sql);
        $row=$memberListCount_rs -> fetch_row();
        $count=$row[0];
        $conn -> close();
        $memberList=array();
        while($memberList_row = $memberList_rs -> fetch_assoc()){
            array_push($memberList,$memberList_row);
        }
        return $connect -> out_msg2(1,'',$count,$this->memberList = $memberList);
    }

    //新增成员
    public function addMember($rid,$member_name,$member_tel,$member_account,$member_password){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $insertMember_sql = "insert into xd_member(rid,member_name,member_tel,member_account,member_password ) VALUE('$rid','$member_name','$member_tel','$member_account','$member_password')";
        $conn ->query($insertMember_sql);
        $insertMember_rs = mysqli_affected_rows($conn);
        $conn -> close();
        if($insertMember_rs){
            return $connect -> out_msg(1,'新增成员成功!');
        }else{
            return $connect -> out_msg(0,'新增成员失败!');
        }
    }

    public function modifyMember($mid,$rid,$member_name,$member_tel,$member_account,$member_password){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $updateMember_sql = "update xd_member set rid = '$rid',member_name = '$member_name',member_tel='$member_tel', ".
            "member_account='$member_account',member_password = '$member_password'  where mid = '$mid' ";
        $conn ->query($updateMember_sql);
        $updateMember_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($updateMember_rs){
            return $connect -> out_msg(1,'更新成员成功!');
        }else{
            return $connect -> out_msg(0,'更新成员失败!');
        }
    }

    public function deleteMember($mid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteMember_sql = "delete from xd_member where mid = '$mid'";
        $conn ->query($deleteMember_sql);
        $deleteMember_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($deleteMember_rs){
            return $connect -> out_msg(1,'删除成员成功!');
        }else{
            return $connect -> out_msg(0,'删除成员失败!');
        }
    }


}



