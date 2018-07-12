<?php

include_once "../../../config/db_config.php";
class Course{
    private $courseList;

    public function __construct(){}

    //检查添加课程重复
    public function selectCourseByName($course_name){
        $selectCourse_sql = "select * from xd_course where course_name = '$course_name'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectCourse_rs=$conn ->query($selectCourse_sql);
        return $selectCourse_row = $selectCourse_rs -> fetch_assoc();
    }

    //检查修改课程重复
    public function selectCourseById($course_id){
        $selectCourse_sql = "select * from xd_course where course_id = '$course_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectCourse_rs=$conn ->query($selectCourse_sql);
        return $selectCourse_row = $selectCourse_rs -> fetch_assoc();
    }

    //获取课程列表
    public function getCourseList($page,$rows,$course_name){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";
        if($course_name){
            $where.= " and course_name like '%$course_name%'";
        }
        $courseList_sql = "select * from xd_course ".$where." limit $offset,$rows";  //sql查询语句，根据课程姓名模糊查询

        $courseList_rs=$conn ->query($courseList_sql);
        $courseList=array();
        $courseListCount_sql = "select count(*) from xd_course ".$where;  //sql查询语句，根据角色姓名模糊查询
        $courseListCount_rs=$conn ->query($courseListCount_sql);
        $row=$courseListCount_rs -> fetch_row();
        $count=$row[0];
        while($courseList_row = $courseList_rs -> fetch_assoc()){

            array_push($courseList,$courseList_row);

        }
        return $connect -> out_msg2(1,'',$count,$this->courseList = $courseList);
    }

    //新增课程
    public function addCourse($course_name,$course_price,$course_leader_mid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        if($this->selectCourseByName($course_name)){
            return $connect -> out_msg(2,'课程已存在!');
        }else{
            $insertCourse_sql = "insert into xd_course(course_name,course_price,course_leader_mid) VALUE('$course_name','$course_price','$course_leader_mid')";
            $conn ->query($insertCourse_sql);
            $insertCourse_rs=mysqli_affected_rows($conn);
            $conn -> close();
            if($insertCourse_rs){
                return $connect -> out_msg(1,'新增课程成功!');
            }else{
                return $connect -> out_msg(0,'新增课程失败!');
            }
        }
    }

    //修改课程
    public function modifyCourse($course_id,$course_name,$course_price,$course_leader_mid){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        //修改商品名称时，不能改为除自身外已有商品名称
        if($this->selectCourseByName($course_name)&&$this->selectCourseById($course_id)['course_name'] != $course_name){
            return $connect -> out_msg(2,'课程已存在!');
        }else{
            $updateCourse_sql = "update xd_course set course_name = '$course_name',course_price='$course_price',course_leader_mid='$course_leader_mid' where course_id = '$course_id' ";
            $conn ->query($updateCourse_sql);
            $updateCourse_rs=mysqli_affected_rows($conn);
            $conn -> close();
            if($updateCourse_rs){
                return $connect -> out_msg(1,'更新课程成功!');
            }else{
                return $connect -> out_msg(0,'更新课程失败!');
            }
        }
    }

    //删除课程
    public function deleteCourse($course_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteAllCourse_sql = "delete from xd_class where course_id = '$course_id'";
        $deleteAllCourse_rs=$conn ->query($deleteAllCourse_sql);
        if($deleteAllCourse_rs){
            $deleteCourse_sql = "delete from xd_course where course_id = '$course_id'";
            $conn ->query($deleteCourse_sql);
            $deleteCourse_rs = mysqli_affected_rows($conn);
            if($deleteCourse_rs){
                return $connect -> out_msg(1,'删除课程成功!');
            }else{
                return $connect -> out_msg(0,'删除课程失败!');
            }
        }
        $conn -> close();
    }

}



