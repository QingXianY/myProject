<?php

include_once "../../../config/db_config.php";
class Competence{
    private $competenceList;

    public function __construct(){}

    //获取权限列表
    public function getCompetenceList(){
        $connect= db_config::getInstance();
        $conn=$connect->connect_bdb();
        $competenceList_sql = "select * from xd_competence";  //sql查询语句，根据权限姓名模糊查询
        $competenceList_rs=$conn ->query($competenceList_sql);
        $competenceList=array();
        while($competenceList_row = $competenceList_rs -> fetch_assoc()){

            array_push($competenceList,$competenceList_row);

        }
        return $connect -> out_msg(1,'',$this->competenceList = $competenceList);
    }



}



