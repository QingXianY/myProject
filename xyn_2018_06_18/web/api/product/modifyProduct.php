<?php

include_once "../../class/Product.php";

$product_id = $_POST['product_id'];
$type_id = $_POST['type_id'];
$product_name = $_POST['product_name'];
$product_pic = $_POST['product_pic'];
$product_price = $_POST['product_price'];
$product_description = $_POST['product_description'];
$product_sale = $_POST['product_sale'];
$product_storage = $_POST['product_storage'];

$Product=new Product();

echo $Product->modifyProduct($product_id,$type_id,$product_name,$product_pic,$product_price,$product_description,$product_sale,$product_storage);

