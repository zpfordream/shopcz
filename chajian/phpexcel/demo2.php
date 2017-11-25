<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/25
 * Time: 17:57
 * demo2，从数据库读取数据内容，并且生成excel,把三个年级数据一个内置表中，并给与简单的样式
 */

$dir = dirname(__FILE__);
require  $dir."/config.php";
require  $dir."/db.php";
require  $dir."/PHPExcel/PHPExcel.php";

$db = new  db($phpexcel);//实例化数据库类
$objPHPExcel = new  PHPExcel();  //实例化类，相当于在桌面上新建一个excel表格
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ;
$objSheet  = $objPHPExcel->getActiveSheet();

$index = 0 ;

$gradeInfo = $db ->getAllGrade();
foreach($gradeInfo as $k =>$g_v){

    $gradeIndex = getCells($index * 2);
    $objSheet->setCellValue( $gradeIndex."2" , "高".$g_v['grade']  ); //获得年级数，因为一个年级循环完后，index才返回，所以每次年级的index能跟下面对上

    $classInfo = $db ->getClassByGrade($g_v['grade']);
//    var_dump($classInfo);
    foreach($classInfo as $k =>$c_v){

        $nameIndex = getCells($index * 2);
        $scoreIndex = getCells($index * 2 + 1);

        $objSheet->setCellValue($nameIndex."3",$c_v['class']."班");     //第三行显示几班
        $objSheet->setCellValue($nameIndex."4","姓名")->setCellValue($scoreIndex."4","成绩");  //第四行显示相同的班级和成绩

        $objSheet ->mergeCells($nameIndex."3:".$scoreIndex."3"); //合并班级的单元格

        $info =  $db->getDataByClassGrade($c_v['class'],$g_v['grade']);
//        var_dump($info);


        $j = 5 ; //学生从第五行开始输出
        foreach( $info as $key => $i_v ){
            $objSheet->setCellValue($nameIndex.$j , $i_v['username'])->setCellValue($scoreIndex.$j ,$i_v["score"]);
            $j++;
        }
        $index++;
    }

    $endGradeIndex = getCells($index*2 -1 ); //这个是合并的时候用的最后单元格，前面的++已经自加完了， 不减1就是grade的下一个单元格了
    $objSheet->mergeCells($gradeIndex."2:".$endGradeIndex."2"); //合并每个年级的单元格

}





//根据下标获得单元格所在的列
function getCells($index){
    $arr = range('a','z');
    return $arr[$index];
}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");//按照指定格式生成excel文件
$objWriter->save("./demo2.xlsx");

