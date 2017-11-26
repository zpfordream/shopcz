<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/26
 * Time: 16:29
 * 主要查看serialize和json的数据不同
 *  http://127.0.0.1/shoucz/chajian/json/json_serialize.php
 *
 */


function createHtmlTag($tag=""){
    echo "<h1>{$tag}</h1>";
}

createHtmlTag("json和serialize的对比");

$member1 = array('username'=>"user1","password"=>"pass1");
$member2 = array(123,"hahaha");


createHtmlTag("this is json");
$jsonObj1 = json_encode($member1);
$jsonObj2 = json_encode($member2);

var_dump($jsonObj1);
var_dump($jsonObj2);


createHtmlTag("this is serialize");
$serialize1 = serialize($member1);
$serialize2 = serialize($member2);

var_dump($serialize1);
var_dump($serialize2);