<?php

include_once "../../../config/db_config.php";
include_once "../../../config/get_time.php";
include_once "Member.php";
class Aclass{
    private $aclassList;
    protected static $aclass;

    public function __construct(){}

    public function selectAclassById($aclass_id){
        $selectAclass_sql = "select * from xd_aclass where aclass_id = '$aclass_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectAclass_rs=$conn ->query($selectAclass_sql);
        return $selectAclass_row = $selectAclass_rs -> fetch_assoc();
    }
    public function selectAclassBydate($aclass_date){
        $selectAclass_sql = "select * from xd_class where  class_date = '$aclass_date'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectAclass_rs=$conn ->query($selectAclass_sql);
        return $selectAclass_row = $selectAclass_rs -> fetch_assoc();
    }
    //根据课程查询，并按开班时间排序
    public function getAclassList($page,$rows,$course_id,$aclass_name){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";
        if($course_id){
            $where.= " and course_id = '$course_id'";
        }elseif($aclass_name){
            $where.= " and class_name like '%$aclass_name%'";
        }
        $aclassList_sql = "select * from xd_class ".$where." order by class_date desc"." limit $offset,$rows";
        $aclassList_rs=$conn ->query($aclassList_sql);
        $aclassListCount_sql = "select count(*) from xd_class ".$where;  //sql查询语句，根据角色姓名模糊查询
        $aclassListCount_rs=$conn ->query($aclassListCount_sql);
        $row=$aclassListCount_rs -> fetch_row();
        $count=$row[0];
        $aclassList=array();

        while($aclassList_row = $aclassList_rs -> fetch_assoc()){
            $class_id = $aclassList_row['class_id'];
            $classTeacher_sql = "select * from v_class_teacher where class_id = '$class_id'";
            $classTeacher_rs=$conn ->query($classTeacher_sql);
            $classTeacherList=array();
            while ($classTeacherList_row = $classTeacher_rs -> fetch_assoc()){
                array_push($classTeacherList,$classTeacherList_row['member_name']);
            }
            $aclassList_row['teacher_list'] = $classTeacherList;
            array_push($aclassList,$aclassList_row);
        }
        $conn -> close();
        return $connect -> out_msg2(1,'',$count,$this->aclassList = $aclassList);
    }

    //新增班级
    public function addAclass($course_id,$aclass_name,$aclass_head,$teacher_arry){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $get_time = new get_time();
        $present = $get_time->get_now_sec();
        $insertAclass_sql = "insert into xd_class(course_id,class_name,class_head,class_date) VALUE('$course_id','$aclass_name','$aclass_head','$present')";
        $conn ->query($insertAclass_sql);
        $insertAclass_rs = mysqli_affected_rows($conn);
        if($insertAclass_rs){
            $aclass_id = $this->selectAclassByDate($present)['class_id'];
            // 关闭自动提交
            mysqli_autocommit($conn,FALSE);
            $i=0;//循环变量
            //--得到$teacher_arry数组长度
            $num=count($teacher_arry);

            //--遍历数组，将对应信息添加入数据库
            for ($i;$i<$num;$i++){
                $mid=$teacher_arry[$i];
                $insertTeacher_sql = "insert into xd_class_teacher(class_id,mid) VALUE('$aclass_id','$mid')";
                $conn -> query($insertTeacher_sql);
            }
            // 提交事务
            mysqli_commit($conn);
            $conn -> close();
            return $connect -> out_msg(1,'新增班级成功!');
        }else{
            return $connect -> out_msg(0,'新增班级失败!');
        }

    }

    public function modifyAclass($aclass_id,$course_id,$aclass_name,$aclass_head,$aclass_date){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $updateAclass_sql = "update xd_class set course_id = '$course_id',class_name = '$aclass_name',class_head='$aclass_head',class_date='$aclass_date' where class_id = '$aclass_id' ";
        $conn ->query($updateAclass_sql);
        $updateAclass_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($updateAclass_rs){
            return $connect -> out_msg(1,'更新班级成功!');
        }else{
            return $connect -> out_msg(0,'更新班级失败!');
        }
    }
    public function deleteAclass($aclass_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteAclass_sql = "delete from xd_aclass where aclass_id = '$aclass_id'";
        $conn ->query($deleteAclass_sql);
        $deleteAclass_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($deleteAclass_rs){
            return $connect -> out_msg(1,'删除班级成功!');
        }else{
            return $connect -> out_msg(0,'删除班级失败!');
        }
    }


}



