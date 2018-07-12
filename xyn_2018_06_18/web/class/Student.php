<?php

include_once "../../../config/db_config.php";
include_once "../../../config/get_time.php";

class Student{
    private $studentList;

    public function __construct(){}

    //学员小程序端登陆方法
    public function login($stu_parent_tel,$stu_password){
        $login_sql = "select * from xd_student where stu_parent_tel = '$stu_parent_tel' and stu_password = '$stu_password'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $login_rs=$conn ->query($login_sql);
        if($login_row = $login_rs -> fetch_assoc()){
            $this->updateLogin($login_row['student_id']);
            return $connect ->out_msg(1,'登陆成功！',$login_row);
        }else{
            return $connect -> out_msg(0,'用户不存在或密码错误');
        }
    }

    //检查重复注册
    public function selectStudentByTel($stu_parent_tel){
        $selectStudent_sql = "select * from xd_student where stu_parent_tel = '$stu_parent_tel'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectStudent_rs=$conn ->query($selectStudent_sql);
        return $selectStudent_row = $selectStudent_rs -> fetch_assoc();
    }

    //根据id查询用户
    public function selectStudentById($student_id){
        $selectStudent_sql = "select * from xd_student where student_id = '$student_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectStudent_rs=$conn ->query($selectStudent_sql);
        return $selectStudent_row = $selectStudent_rs -> fetch_assoc();
    }

    //更新学员小程序最后登陆时间
    public function updateLogin($student_id){
        $get_time = new get_time();
        $last_login = $get_time->get_now_sec();
        $updateLogin_sql = "update xd_student set last_login = '$last_login' where student_id = '$student_id'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $conn ->query($updateLogin_sql);
    }

    //学员更改登陆密码或初次登陆设置密码
    public function register($stu_parent_tel,$message_code,$stu_password){
        $connect= db_config::getInstance();
        $register_sql = "update xd_student set stu_password = '$stu_password' where stu_parent_tel = '$stu_parent_tel' and message_code = '$message_code'";
        $conn=$connect->connect_bdb();
        $conn ->query($register_sql);
        $register_rs = mysqli_affected_rows($conn);
        $conn->close();
        if($register_rs){
            return $connect -> out_msg(1,'验证通过，注册成功!');;
        }else{
            return $connect -> out_msg(0,'验证码错误，注册失败!');
        }

    }
    //根据家长手机号查询，用于检查注册用户是否为会员
    public function checkTel($stu_parent_tel){
        $selectStudent_sql = "select * from xd_student where stu_parent_tel = '$stu_parent_tel'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $selectStudent_rs=$conn ->query($selectStudent_sql);
        $conn -> close();
        return $selectStudent_row = $selectStudent_rs -> fetch_assoc();
    }

    //保存随机短信验证码
    public function saveMessageCode($stu_parent_tel,$code){
        $saveCode_sql = "update xd_student set message_code = '$code' where stu_parent_tel = '$stu_parent_tel'";
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $conn ->query($saveCode_sql);
        $conn -> close();
    }

    //获取学生列表
    public function getStudentList($page,$rows,$class_id,$student_name,$student_parent_name,$stu_parent_tel){
        $offset = ($page-1)*$rows;
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";
        if($class_id){
            $where.= " and class_id = '$class_id'";
        }
        if($student_name){
            $where.= " and stu_name like '%$student_name%'";
        }elseif($student_parent_name){
            $where.= " and student_parent_name like '%$student_parent_name%'";
        }elseif($stu_parent_tel){
            $where.= " and stu_parent_tel = '$stu_parent_tel'";
        }
        $studentList_sql = "select * from v_class_student ".$where." limit $offset,$rows";  //sql查询语句，根据学生姓名模糊查询
        $studentList_rs=$conn ->query($studentList_sql);
        $studentList=array();
        $studentListCount_sql = "select count(*) from v_class_student ".$where;  //sql查询语句，根据角色姓名模糊查询
        $studentListCount_rs=$conn ->query($studentListCount_sql);
        $row=$studentListCount_rs -> fetch_row();
        $count=$row[0];
        while($studentList_row = $studentList_rs -> fetch_assoc()){
            array_push($studentList,$studentList_row);
        }
        return $connect -> out_msg2(1,'',$count,$this->studentList = $studentList);
    }

    //获取学生列表,筛选后导出
    public function getStudentList2($class_id,$student_name,$student_parent_name,$stu_parent_tel){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $where = "where 1=1";
        if($class_id){
            $where.= " and class_id = '$class_id'";
        }
        if($student_name){
            $where.= " and stu_name like '%$student_name%'";
        }elseif($student_parent_name){
            $where.= " and student_parent_name like '%$student_parent_name%'";
        }elseif($stu_parent_tel){
            $where.= " and stu_parent_tel = '$stu_parent_tel'";
        }
        $studentList_sql = "select * from v_class_student ".$where;  //sql查询语句，根据学生姓名模糊查询
        $studentList_rs=$conn ->query($studentList_sql);
        return $studentList_rs;
    }

    //新增学生
    public function addStudent($stu_name,$stu_parent,$stu_parent_tel,$stu_password){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        if($this->selectStudentByTel($stu_parent_tel)){
            return $connect -> out_msg(2,'登录手机号重复!');
        }else{
            $insertStudent_sql = "insert into xd_student(stu_name,stu_parent,stu_parent_tel,stu_password,stu_integral) VALUE('$stu_name','$stu_parent','$stu_parent_tel','$stu_password',0)";
            $conn ->query($insertStudent_sql);
            $insertStudent_rs=mysqli_affected_rows($conn);
            $conn -> close();
            if($insertStudent_rs){
                return $connect -> out_msg(1,'新增学生成功!');
            }else{
                return $connect -> out_msg(0,'新增学生失败!');
            }
        }
    }

    public function modifyStudent($student_id,$stu_name,$stu_parent,$stu_parent_tel,$stu_password){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        if($this->selectStudentByTel($stu_parent_tel)&&$this->selectStudentById($student_id)['stu_parent_tel'] != $stu_parent_tel){
            return $connect -> out_msg(2,'登录手机号重复!');
        }else{
            $updateStudent_sql = "update xd_student set stu_name = '$stu_name',stu_parent='$stu_parent',stu_parent_tel = '$stu_parent_tel',stu_password = '$stu_password' where student_id = '$student_id' ";
            $conn ->query($updateStudent_sql);
            $updateStudent_rs=mysqli_affected_rows($conn);
            $conn -> close();
            if($updateStudent_rs){
                return $connect -> out_msg(1,'更新学生成功!');
            }else{
                return $connect -> out_msg(0,'更新学生失败!');
            }
        }
    }

    //操作用户积分
    public function modifyStudentIntegral($student_id,$modify_type,$modify_value){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $student_integral = $this->selectStudentById($student_id)['stu_integral'];
        $stu_integral_new= $modify_type==0?$student_integral-$modify_value:$student_integral+$modify_value;
        $updateStudent_sql = "update xd_student set stu_integral = '$stu_integral_new' where student_id = '$student_id' ";
        $conn ->query($updateStudent_sql);
        $updateStudent_rs=mysqli_affected_rows($conn);
        $conn -> close();
        if($updateStudent_rs){
            return $connect -> out_msg(1,'操作积分成功!');
        }else{
            return $connect -> out_msg(0,'操作积分失败!');
        }
    }
    //
    public function deleteStudent($student_id){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $deleteStudent_sql = "delete from xd_student where student_id = '$student_id'";
        $conn ->query($deleteStudent_sql);
        $deleteStudent_rs=mysqli_affected_rows($conn);
        if($deleteStudent_rs){
            return $connect -> out_msg(1,'删除学生成功!');
        }else{
            return $connect -> out_msg(0,'删除学生失败!');
        }
        $conn -> close();
    }
}



