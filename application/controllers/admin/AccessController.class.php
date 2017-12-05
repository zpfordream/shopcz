<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-12-05
 * Time: 10:57
 */

class AccessController extends BaseController{


    //添加权限的添加页面 http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=add
    public  function  addAction(){

        $accessModel  =  new AccessModel('auth_rule');
        $accesses     =  $accessModel->getAccess();
        var_dump($accesses);

        include  CUR_VIEW_PATH."access_add.html";
    }

    //插入后台的数据 http://127.0.0.1/shopcz/index.php?p=admin&c=access&a=insert
    public function  insertAction(){

        //1. 收集表单数据
        $data['pid']        =     $_POST['pid'];
        $data['title']      =    trim($_POST['title']);
        $data['url']        =    trim($_POST['url']);
        $data['status']    =    $_POST['status'];

        //2.验证及处理
        //判断分类名称不能为空
        if($data['title'] === ""){
            $this->jump("index.php?p=admin&c=access&a=add","权限名称不能为空",3);
        }
        if($data['url'] === ""){
            $this->jump("index.php?p=admin&c=access&a=add","权限URL不能为空",3);
        }

        //3. 调用模型，完成入库，并给于提示
        $accessModel = new AccessModel("auth_rule");
        if($accessModel->insert($data)){
            $this ->jump("index.php?p=admin&c=access&a=add","添加权限成功",3);
        }else{
            $this ->jump("index.php?p=admin&c=access&a=add","添加权限失败",3);
        }
    }








}