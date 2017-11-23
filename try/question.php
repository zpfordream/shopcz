<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/23
 * Time: 21:36
 */
//first ，一个数组，不指定什么下标，是索引数组？  答案，是
$arr[]  =1;
$arr[] =2 ;
$arr[] =3;
foreach($arr as $k =>$v){
    echo $k ."=>". $v;
    echo "<br>";
}

// 一个是赋值，一个是添加一个元素
$arr1   =  $arr;
$arr2[] =  $arr ;
var_dump($arr1);
var_dump($arr2);
$arr3[][] =  $arr ;
var_dump($arr3);