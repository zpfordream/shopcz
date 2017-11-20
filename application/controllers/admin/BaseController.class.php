<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-11-01
 * Time: 13:14
 */

class  BaseController extends Controller{

    public function __construct()
    {
        $this->checkLogin();
    }

    public function checkLogin(){

        //只检查是否有session，如果没有，就给出提示，同时跳到登录页面
        if(empty($_SESSION['admin'])){
            $this->jump("index.php?p=admin&c=Login&a=login","您还没有登录呢",3);
        }
    }





}