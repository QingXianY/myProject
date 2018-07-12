<?php

include_once "../../class/Course.php";

$course_name = isset($_GET['course_name'])?$_GET['course_name']:null;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$rows = isset($_GET['limit']) ? intval($_GET['limit']) : 10;

$Course = new Course();

echo $Course->getCourseList($page,$rows,$course_name);

