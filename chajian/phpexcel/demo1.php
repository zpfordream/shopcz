<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/25
 * Time: 11:53
 * demo1，从数据库读取数据内容，并且生成excel,把三个年级数据放到三个内置表中
 */

$dir = dirname(__FILE__);
require  $dir."/config.php";
require  $dir."/db.php";
require  $dir."/PHPExcel/PHPExcel.php";

$db = new  db($phpexcel);//实例化数据库类

$objPHPExcel = new  PHPExcel();  //实例化类，相当于在桌面上新建一个excel表格

for($i=1 ; $i <= 3 ; $i++){

    if( $i > 1 ){
        $objPHPExcel ->createSheet(); //创建新的内置表，实例化的时候，创建一个excel 会自动创建一个内置表，所以现在是第二个才会创建
    }

    $objPHPExcel->setActiveSheetIndex($i-1); //把新创建的sheet设定为当前的活动sheet，在excel中活动sheet的索引是0开始
    $objSheet = $objPHPExcel->getActiveSheet(); //获取当前的活动sheet
    $objSheet->setTitle($i."年级");              //设置当前活动sheet的名称

    $data = $db ->getDataByGrade( $i ) ; //查询每个年级的用书数据
    $objSheet->setCellValue("A1","姓名")->setCellValue("B1","分数")->setCellValue("C1","班级"); //设置数据

    $j = 2;

    foreach($data as $key => $value){

        $objSheet->setCellValue("A".$j , $value['username'])->setCellValue("B".$j , $value['score'])->setCellValue("C".$j , $value['class']);
        $j++ ;
    }

}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");//按照指定格式生成excel文件
$objWriter->save("./demo1.xlsx");

//按照案例来的，但是打印到浏览器有问题，还是自动输出到当前文件吧，到公司试试
//browser_export("Excel07","demo1.xlsx");
//$objWriter->save('php://output');



function browser_export( $type ,$filename ){

    if( $type =="Excel5"){
        header('Content-Type: application/vnd.ms-excel'); //告诉浏览器输出excel03文件
    }else{
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器输出excel07文件
    }

    header('Content-Disposition: attachment;filename="'.$filename.'"');//告诉浏览器输出文件的名称
    header('Cache-Control: max-age=0');//禁止缓存

}