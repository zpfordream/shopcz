<?php

// 1
$member["username"] = "mukewang";
$member["password"] = "mukewang";


//2
$members['1']["username"] = "zpmff";
$members['1']["password"] = "aaaaaa";
$members['2']["username"] = "zpfordream";
$members['2']["password"] = "hahahaha";
$members['2']["address"] = "北京市朝阳";
$members['third']["members"]['username'] = "哈哈哈哈哈";

//3
class addressClass{
    public  $address = array(1,2,3);
}

$addObj = new addressClass();

$do = $_GET['do'];

switch($do){
    case "first":
        echo json_encode($member);
        break;
    case "second":
        echo json_encode($members);
        break;
    case "third":
        echo  json_encode($addObj);
        break;
}