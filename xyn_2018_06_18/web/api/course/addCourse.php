<?php

include_once "../../class/Course.php";

$course_name = $_POST['course_name'];
$course_price = $_POST['course_price'];
$course_leader_mid = $_POST['course_leader_mid'];

$Course = new Course();
echo $Course->addCourse($course_name,$course_price,$course_leader_mid);

