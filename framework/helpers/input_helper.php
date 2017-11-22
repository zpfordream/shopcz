<?php

/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/5
 * Time: 11:53
 * deepslashes主要是对于传入的get或者post参数，进行转义操作，以防止被攻击,主要是面对sql注入的攻击
 * addslashes主要是对四种类型，一是单引号，二是双引号，三是反斜杠，四是null
 *
 * deepstripslashes,主要是针对之前转义后的函数，进行反转义，又变回原来的函数了
 * stripslashes，主要是对addslashes转以后的字符串，再次转义回去
 *
 * 访问地址    127.0.0.1/shijian/addslashes.php?aa="aa"&bb=\bb
 */

function deepslashes( $data ){

	//判断，传入的数据是一维数组还是二维数组，同时验证空处理
	if(empty($data)){
		return $data;
	}

//    if(is_array($data)){
//        static  $new_data = array();
//        foreach($data as $key=>$value){
//             $new_data[$key] = addslashes($value);
//        }
//        return $new_data;
//    }else{
//        return addslashes($data);
//    }


	//以下为高级写法，代替上面注释的内容
	return  is_array($data)? array_map("addslashes",$data) :addslashes($data);
}

//测试内容，127.0.0.1/shijian/addslashes.php?aa="aa"&bb=\bb， 特意用get访问，传入两个非常用字符串
//$get_data = $_GET;
//var_dump($_GET);
//
//$new_get_data = deepslashes($get_data);
//var_dump($new_get_data);

function deepstripslashes($data){

	if(empty($data)){
		return $data;
	}

	return is_array($data)? array_map("stripslashes",$data) :stripslashes($data) ;
}

//$yuan_data = deepstripslashes($new_get_data);
//var_dump($yuan_data);


/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/5
 * Time: 12:32
 * xss攻击的本质，通过 标签（一对尖括号）来达到攻击的目的，所以我们只需要将尖括号 进行 转义，这就是php中提到的 实体转义
 * Htmlspecialchars函数 和  htmlentites函数，都是将字符转换为 HTML 实体，所有有表单输入的地方，都需要进行实体转义。
 *
 * Htmlspecialchars，函数只能转化以下这几种html实体
 *  '&' (ampersand) becomes '&'
'"' (double quote) becomes '"' when ENT_NOQUOTES is not set.
''' (single quote) becomes ''' only when ENT_QUOTES is set.
'<' (less than) becomes '<'
'>' (greater than) becomes '>'
 *
 * htmlentites，能转化所有的html实体，连同里面的它无法识别的中文字符也给转化了。所以有中文的时候尽量用Htmlspecialchars，
 * 以免出现乱码
 *
 *
 * 访问地址  127.0.0.1/shijian/htmlspecialchars.php
 */

function deepspecialchars($data){

	if(empty($data)){
		return $data;
	}

	return is_array($data)? array_map("htmlspecialchars",$data) :htmlspecialchars($data);
}

//$str = "<script>alert(1)<script>";
//echo deepspecialchars($str);
//echo "<br>";
//echo $str;