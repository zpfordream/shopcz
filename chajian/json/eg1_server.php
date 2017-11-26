<?php
require "../phpexcel/config.php";
require "../phpexcel/db.php";



$inAjax = $_GET['inAjax'];
$username = $_GET["username"];
$do = $_GET["do"];
$do = isset($do)? $do: "default";

//判断是不是目标页面来的，不是的话 返回错误
if(!$inAjax){
    return false;
}

switch($do){
    case "checkMember":
        //本来准备用数据库的，结果杂乱的信息太多了，就放弃了
//        $db =new db($phpexcel);
//        $sql= "select * from user_json WHERE username = {$username}";
//        $res = $db->getResult($sql);
        $res = array("username"=>"abcde","groupname"=>1,"uid"=>1,"addtime"=>11111);
        echo (!empty($res))? json_encode($res) : "null";

        break;
    case "default":
        die("nothing");
        break;
}