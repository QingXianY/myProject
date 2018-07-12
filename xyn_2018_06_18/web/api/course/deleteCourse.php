<?php

include_once "../../class/Course.php";

$course_id = $_GET['course_id'];


$Course = new Course();

echo $Course->deleteCourse($course_id);