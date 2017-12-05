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
//        var_dump($accesses);

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


    //分类的列表页 http://127.0.0.1/shopcz/index.php?p=admin&c=access&a=index
    public  function  indexAction(){

        $accessModel  =  new AccessModel('auth_rule');
        $accesses     =  $accessModel->getAccess();
//        var_dump($accesses);
        include  CUR_VIEW_PATH."access_list.html";
    }



    //载入编辑分类动作  http://127.0.0.1/shopcz/index.php?p=admin&c=access&a=edit
    public  function  editAction(){
        //1.获取当前分类信息
        $access_id = $_GET['id'] + 0 ;
        $accessModel  =  new AccessModel('auth_rule');
        $access = $accessModel->selectByPk($access_id);
//        var_dump($access);
        //2.获取所有的分类信息
        $accesses = $accessModel->getAccess();
//        var_dump($accesses);
        //3.载入编辑表单
        include  CUR_VIEW_PATH."access_edit.html";
    }

    //载入编辑分类后，修改后，提交动作，http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=updateAction
    public function updateAction(){

        //1. 收集表单数据
        $data['title'] = trim($_POST['title']);
        $data['id'] = $_POST['id'];
        $data['pid'] = $_POST['pid'];
        $data['url'] = trim($_POST['url']);
        $data['status'] = $_POST['status'];

        //2. 验证及处理
        //判断分类名称不能为空
        if($data['title'] === ""){
            $this->jump("index.php?p=admin&c=access&a=add","权限名称不能为空",3);
        }
        if($data['url'] === ""){
            $this->jump("index.php?p=admin&c=access&a=add","权限URL不能为空",3);
        }

        //不能将当前节点及其子节点作为上级节点
        $accessModel  =  new AccessModel('auth_rule');
        ////获取当前节点的所有子孙节点,同时把自己也放进去
        $ids = $accessModel->getSubIds($data['id']);
        $ids[] = $data['id'];
        //判断要更改的父节点不在所有的子孙节点中
        if(in_array($data['pid'] , $ids)){
            $this->jump('index.php?p=admin&c=access&a=edit&id='.$data['id'],"不能将当前节点及其子节点作为上级节点",3);
        }
        //3. 调用模型完成更新操作
        if($accessModel->update($data)){
            $this->jump("index.php?p=admin&c=access&a=index","更新成功",2);
        }else{
            $this->jump("index.php?p=admin&c=access&a=edit&id=".$data['id'],"更新失败",3);
        }

    }

    //删除商品分类
    public function deleteAction(){
        //1. 获取id，作为条件
        $id = $_GET['id'] + 0;
        //2. 做一些相应的判断
        //如果不是叶子分类，则不允许删除
        $accessModel  =  new AccessModel('auth_rule');
        $ids = $accessModel->getSubIds($id);
        if (!empty($ids)){
            $this->jump('index.php?p=admin&c=access&a=index','当前分类不是叶子分类，不能删除',5);
        }
        //3. 调用模型，完成删除，并给出提示
        if ($accessModel->delete($id)){
            $this->jump('index.php?p=admin&c=access&a=index',"删除权限名称成功",2);
        }else {
            $this->jump('index.php?p=admin&c=category&a=index',"删除权限名称失败",3);
        }
    }

}