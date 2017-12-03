<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-10-12
 * Time: 13:43
 */


//编写后台首页控制器，测试效果
//http://127.0.0.1/shopcz/index.php?p=admin&c=index&a=index
//http://127.0.0.1/shopcz/index.php?p=admin    都能访问到
class IndexController extends  BaseController{

    public  function indexAction(){
       // echo "admin index";
        //include一个html页面，相当于打开一个新页面


//        $adminModel = new AdminModel("admin"); //传入表名
//        $admins = $adminModel->test();
//        var_dump($admins);

        include CUR_VIEW_PATH."index.html";

    }

    public  function topAction(){
        include CUR_VIEW_PATH."top.html";
    }

    public  function menuAction(){

        $menuModel = new IndexModel("admin_nav");
        $menus = $menuModel->getNavs();
//        var_dump($menus);
        include CUR_VIEW_PATH."menu.html";
    }

    public  function dragAction(){
        include CUR_VIEW_PATH."drag.html";
    }

    public  function mainAction(){
        include CUR_VIEW_PATH."main.html";
    }
}