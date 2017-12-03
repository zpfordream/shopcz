<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/12/1
 * Time: 22:45
 * 后台左边的导航列表，包括增删改查
 */

class NavController extends BaseController{


    //添加导航的页面 http://127.0.0.1/shoucz/index.php?p=admin&c=Nav&a=add
    public function addAction(){
        $nav = new NavModel('admin_nav');
        $navs = $nav->getNavs();
        include CUR_VIEW_PATH."nav_add.html";
    }



    //插入后台的数据 http://127.0.0.1/shoucz/index.php?p=admin&c=Nav&a=insert
    public function  insertAction(){
        //1. 收集表单数据
        $data['name']    =    trim($_POST['name']);
        $data['pid']    =    trim($_POST['pid']);
        $data['mvc']    =    trim($_POST['mvc']);


        //2.验证及处理
        //判断分类名称不能为空
        if($data['name'] === ""){
            $this->jump("index.php?p=admin&c=Nav&a=add","分类名称不能为空",3);
        }

        //3. 调用模型，完成入库，并给于提示
        $nav = new NavModel("admin_nav");
        if($nav->insert($data)){
            $this ->jump("index.php?p=admin&c=Nav&a=add","添加导航成功",3);
        }else{
            $this ->jump("index.php?p=admin&c=Nav&a=add","添加导航失败",3);
        }
    }

    //分类的列表页 http://127.0.0.1/shoucz/index.php?p=admin&c=Nav&a=index
    public  function  indexAction(){

        $nav = new NavModel('admin_nav');
        $navs  = $nav->getNavs();
//       var_dump($navs);
        include  CUR_VIEW_PATH."nav_list.html";
    }



    //载入编辑分类动作  http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=edit
    public  function  editAction(){
        //1.获取当前分类信息
        $id = $_GET['id'] + 0 ;
        $navModel = new NavModel('admin_nav');
        $nav = $navModel->selectByPk($id);
//        var_dump($nav);
        //2.获取所有的分类信息
        $navs = $navModel->getNavs();
//        var_dump($navs);
        //3.载入编辑表单
        include  CUR_VIEW_PATH."nav_edit.html";
    }



    //载入编辑分类后，修改后，提交动作，http://127.0.0.1/shopcz/index.php?p=admin&c=Nav&a=updateAction
    public function updateAction(){

        //1. 收集表单数据
        $data['name'] = trim($_POST['name']);
        $data['pid'] = $_POST['pid'];
        $data['mvc'] = trim($_POST['mvc']);
        $data['id'] = trim($_POST['id']);

        //2. 验证及处理
        //判断分类名称不能为空
        if ($data['name'] === ""){
            $this->jump("index.php?p=admin&c=nav&a=add","分类名称不能为空",3);
        }
        //不能将当前节点及其子节点作为上级节点
        $navModel = new NavModel('admin_nav');
        ////获取当前节点的所有子孙节点,同时把自己也放进去
        $ids = $navModel->getSubIds($data['id']);
        $ids[] = $data['id'];
        //判断要更改的父节点不在所有的子孙节点中
        if(in_array($data['pid'] , $ids)){
            $this->jump('index.php?p=admin&c=nav&a=edit&id='.$data['id'],"不能将当前节点及其子节点作为上级节点",3);
        }
        //3. 调用模型完成更新操作
        if($navModel->update($data)){
            $this->jump("index.php?p=admin&c=nav&a=index","更新成功",2);
        }else{
            $this->jump("index.php?p=admin&c=nav&a=edit&id=".$data['id'],"更新失败",3);
        }

    }

    //删除商品分类
    public function deleteAction(){
        //1. 获取cat_id，作为条件
        $id = $_GET['id'] + 0;
        //2. 做一些相应的判断
        //如果不是叶子分类，则不允许删除
        $navModel = new NavModel("admin_nav");
        $navs = $navModel->getSubIds($id);
        if (!empty($navs)){
            $this->jump('index.php?p=admin&c=nav&a=index','当前分类不是叶子分类，不能删除',5);
        }
        //3. 调用模型，完成删除，并给出提示
        if ($navModel->delete($id)){
            $this->jump('index.php?p=admin&c=nav&a=index',"删除菜单成功",2);
        }else {
            $this->jump('index.php?p=admin&c=nav&a=index',"删除菜单失败",3);
        }
    }
























}