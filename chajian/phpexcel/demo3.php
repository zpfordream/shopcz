<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/25
 * Time: 22:11
 * 从excel 中导入php
 * http://127.0.0.1/shoucz/chajian/phpexcel/demo3.php
 */

$dir = dirname(__FILE__);
require  $dir."/PHPExcel/PHPExcel/IOFactory.php"; //引入 读取excel类文件

$filename = $dir."/demo1.xlsx";   //文件名

$objPHPExcel = PHPExcel_IOFactory::load($filename);   //加载文件

$sheetCount = $objPHPExcel->getSheetCount();
for($i=0 ; $i< $sheetCount ;$i++){
    $data = $objPHPExcel->getSheet($i)->toArray();
    var_dump($data);
}