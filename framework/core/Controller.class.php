<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-10-13
 * Time: 14:57
 */

//基础控制器
class Controller {

    //定义跳转方法
    public  function  jump($url , $message ,$wait =3){
        if($wait == 0){
            header("Location:{$url}");
        }else{
            include CUR_VIEW_PATH."message.html";
        }

        //要强制退出,都到一个新的页面了，你当前页面的进程就应该结束
        exit();
    }


    //定义载入辅助函数的方法，如input_helper.php文件
    public  function helper($helper){
        require HELPER_PATH."{$helper}_helper.php";
    }

    //定义载入类库的方法，如 Page.class.php
    public function library($lib){
        require LIB_PATH."{$lib}.class.php";
    }

}