<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-10-19
 * Time: 12:45
 * 商品分类的控制器
 * http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=add
 */

class CategoryController extends BaseController{

    //添加分类的添加页面 http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=add
    public  function  addAction(){

        $categoryModel  =  new CategoryModel('category');
        $cats           =  $categoryModel->getCats();
        var_dump($cats);

        include  CUR_VIEW_PATH."cat_add.html";
    }

    //插入后台的数据 http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=insert
    public function  insertAction(){
        //1. 收集表单数据
        $data['cat_name']    =    trim($_POST['cat_name']);
        $data['parent_id']    =    trim($_POST['parent_id']);
        $data['unit']    =    trim($_POST['unit']);
        $data['sort_order']    =    trim($_POST['sort_order']);
        $data['is_show']    =    trim($_POST['is_show']);
        $data['cat_desc']    =    trim($_POST['cat_desc']);

        //2.验证及处理
        //判断分类名称不能为空
        if($data['cat_name'] === ""){
            $this->jump("index.php?p=admin&c=Category&a=add","分类名称不能为空",3);
        }

        //3. 调用模型，完成入库，并给于提示
        $categoryModel = new CategoryModel("category");
        if($categoryModel->insert($data)){
            $this ->jump("index.php?p=admin&c=Category&a=index","添加分类成功",3);
        }else{
            $this ->jump("index.php?p=admin&c=Category&a=add","添加分类失败",3);
        }
    }


    //分类的列表页 http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=index
    public  function  indexAction(){

        $categoryModel = new CategoryModel('category');
        $cats  = $categoryModel->getCats();
        var_dump($cats);
        include  CUR_VIEW_PATH."cat_list.html";
    }

    //载入编辑分类动作  http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=edit
    public  function  editAction(){
        //1.获取当前分类信息
        $cat_id = $_GET['cat_id'] + 0 ;
        $categoryModel = new CategoryModel('category');
        $cat = $categoryModel->selectByPk($cat_id);
        //var_dump($cat);
        //2.获取所有的分类信息
        $cats = $categoryModel->getCats();
        //var_dump($cats);
        //3.载入编辑表单
        include  CUR_VIEW_PATH."cat_edit.html";
    }

    //载入编辑分类后，修改后，提交动作，http://127.0.0.1/shopcz/index.php?p=admin&c=Category&a=updateAction
    public function updateAction(){

        //1. 收集表单数据
        $data['cat_name'] = trim($_POST['cat_name']);
        $data['parent_id'] = $_POST['parent_id'];
        $data['unit'] = trim($_POST['unit']);
        $data['sort_order'] = trim($_POST['sort_order']);
        $data['is_show'] = $_POST['is_show'];
        $data['cat_desc'] = trim($_POST['cat_desc']);
        $data['cat_id'] = $_POST['cat_id'];
        //2. 验证及处理
        //判断分类名称不能为空
        if ($data['cat_name'] === ""){
            $this->jump("index.php?p=admin&c=category&a=add","分类名称不能为空",3);
        }
        //不能将当前节点及其子节点作为上级节点
        $categoryModel = new CategoryModel('category');
        ////获取当前节点的所有子孙节点,同时把自己也放进去
        $ids = $categoryModel->getSubIds($data['cat_id']);
        $ids[] = $data['cat_id'];
        //判断要更改的父节点不在所有的子孙节点中
        if(in_array($data['parent_id'] , $ids)){
            $this->jump('index.php?p=admin&c=category&a=edit&cat_id='.$data['cat_id'],"不能将当前节点及其子节点作为上级节点",3);
        }
        //3. 调用模型完成更新操作
        if($categoryModel->update($data)){
            $this->jump("index.php?p=admin&c=category&a=index","更新成功",2);
        }else{
            $this->jump("index.php?p=admin&c=category&a=edit&cat_id=".$data['cat_id'],"更新失败",3);
        }

    }

    //删除商品分类
    public function deleteAction(){
        //1. 获取cat_id，作为条件
        $cat_id = $_GET['cat_id'] + 0;
        //2. 做一些相应的判断
        //如果不是叶子分类，则不允许删除
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->getSubIds($cat_id);
        if (!empty($cats)){
            $this->jump('index.php?p=admin&c=category&a=index','当前分类不是叶子分类，不能删除',5);
        }
        //3. 调用模型，完成删除，并给出提示
        if ($categoryModel->delete($cat_id)){
            $this->jump('index.php?p=admin&c=category&a=index',"删除商品分类成功",2);
        }else {
            $this->jump('index.php?p=admin&c=category&a=index',"删除商品分类失败",3);
        }
    }

}