<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/23
 * Time: 23:00
 * demo 是一个简单的在文件中生成excel的案例
 */

// http://127.0.0.1/shoucz/chajian/phpexcel/demo.php

require "./PHPExcel/PHPExcel.php";

$objPHPExcel = new  PHPExcel();  //实例化类，相当于在桌面上新建一个excel表格
$objSheet = $objPHPExcel->getActiveSheet(); //获得当前活动sheet的操作对象
$objSheet->setTitle("demo");              //设置当前活动sheet的名称

//给当前活动的sheet填充数据，这是一个一个填，下面还有第二种方法 数组整体添加
$objSheet ->setCellValue("A1","姓名")->setCellValue("B1","分数")->setCellValue("A2","张三")->setCellValue("B2","李四");


//这是第二种添加数据方法，直接按照数组填充
//$arr = array( array(),
//               array("","姓名","分数") ,
//               array("","张三","60") ,
//               array("","李四","70"),
//                );
//$objSheet->fromArray($arr);



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");//按照指定格式生成excel文件
$objWriter->save("./demo.xlsx");