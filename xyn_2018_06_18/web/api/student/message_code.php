<?php


require_once    "../../../sms_php_sdk/SmsSingleSender.php";//短信单发
include_once "../../class/Student.php";

use Sms\SmsSingleSender;


try {

    $appid = 140009813705;
    $appkey = "892138c566adaebff29a866468715746";
    $phoneNumber = $_GET['stu_parent_tel'];
    $student = new Student();
    //判断用户是否为会员
    if($student->checkTel($phoneNumber)){
        $singleSender = new SmsSingleSender($appid, $appkey);

        // 指定模板单发
        // 假设模板内容为：{1}为您的登录验证码，请于{2}分钟内填写。如非本人操作，请忽略本短信。

        $randCode = rand(1000,9999);  //随机生成验证码
        $student->saveMessageCode($phoneNumber,$randCode);
        $params = array($randCode, "3");
        $templId=146393;
        $sign='兴达科技';
        $result = $singleSender->sendWithParam("86", $phoneNumber, $templId, $params,$sign," ");
        $rsp = json_decode($result);
        echo $result;
        echo "<br>";

    }else{
        $out_msg= array(
            'status' => 0,
            'msg' => '抱歉，该手机号非西英诺会员，无法注册！',
            'data' => ''
        );
        echo json_encode($out_msg);
    }


} catch (\Exception $e) {
    echo var_dump($e);
}
