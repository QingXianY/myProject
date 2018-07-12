<?php

include_once "../../class/Role.php";

$role_name = $_POST['role_name'];
$role_amount = $_POST['role_amount'];
$competence_arry = $_POST['competence_arry'];
$competence_arry=json_decode($competence_arry,true);

$Role=new Role();

echo $Role->addRole($role_name,$role_amount,$competence_arry);