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



//载入excel 文件，分为全部读取和选择加载

//全部加载
//$objPHPExcel = PHPExcel_IOFactory::load($filename);   //加载文件

//选择加载
$filetype = PHPExcel_IOFactory::identify($filename); //自动获取文件类型提供给phpexcel用, $filetype输出是Excel2007，
//var_dump($filetype);
$objReader = PHPExcel_IOFactory::createReader($filetype); //获取文件读取操作对象
$sheetName = array("2年级","3年级");
$objReader ->setLoadSheetsOnly($sheetName);   //只加载指定sheet
$objPHPExcel = $objReader->load($filename);   //加载文件


//读取excel 文件，分为全部读取和逐行读取

/* 下面是把每个sheet 全部加载进，内存，耗内存 ；还有一种部分加载
$sheetCount = $objPHPExcel->getSheetCount();   //获取excel文件里有几个sheet
for($i=0 ; $i< $sheetCount ;$i++){
    $data = $objPHPExcel->getSheet($i)->toArray(); //读取每个sheet，然后把每个sheet的数据全部加载进来，全部加载耗内存
    var_dump($data);
}

*/

//逐行加载每个sheet里的数据，省内存
foreach( $objPHPExcel ->getWorksheetIterator() as $sheet){    //迭代器循环取sheet

    foreach($sheet->getRowIterator() as $row){              //迭代器循环取行，逐行取数据

        if( $row->getRowIndex() < 1 ){                        //逐行取数据，过滤掉第一行
            continue;
        }

        foreach($row->getCellIterator() as $cell){          //迭代器循环单元格

            $data = $cell->getValue();
            echo $data."  ";

        }
        echo "<br>";
    }
    echo "<br>";
}