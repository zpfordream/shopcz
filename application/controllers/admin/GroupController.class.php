<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/12/2
 * Time: 13:34
 * 用户组表
 */

class GroupController extends Controller{

    //添加用户组的页面 http://127.0.0.1/shoucz/index.php?p=admin&c=group&a=add
    public function addAction(){

//        $navs = $nav->getNavs();
        include CUR_VIEW_PATH."group_add.html";
    }



    //插入后台的数据 http://127.0.0.1/shoucz/index.php?p=admin&c=group&a=insert
    public function  insertAction(){
        //1. 收集表单数据
        $data['title']    =    trim($_POST['title']);

        //2.验证及处理
        //判断分类名称不能为空
        if($data['title'] === ""){
            $this->jump("index.php?p=admin&c=title&a=add","用户组名不能为空",3);
        }

        //3. 调用模型，完成入库，并给于提示
        $group = new GroupModel("auth_group");
        if($group->insert($data)){
            $this ->jump("index.php?p=admin&c=Group&a=add","添加用户组成功",3);
        }else{
            $this ->jump("index.php?p=admin&c=Group&a=add","添加用户组失败",3);
        }
    }


    //分类的列表页 http://127.0.0.1/shoucz/index.php?p=admin&c=group&a=index
    public  function  indexAction(){

        $group = new GroupModel('auth_group');;
        $groups  = $group->getGroups();
//       var_dump($groups);
        include  CUR_VIEW_PATH."group_list.html";
    }


    //载入编辑分类动作  http://127.0.0.1/shopcz/index.php?p=admin&c=group&a=edit
    public  function  editAction(){
        //1.获取当前用户组信息
        $id = $_GET['id'] + 0 ;

        $groupModel = new GroupModel('auth_group');
        $group = $groupModel->selectByPk($id);
//        var_dump($group);

        //3.载入编辑表单
        include  CUR_VIEW_PATH."group_edit.html";
    }



    //载入编辑分类后，修改后，提交动作，http://127.0.0.1/shopcz/index.php?p=admin&c=Nav&a=updateAction
    public function updateAction(){

        //1. 收集表单数据
        $data['title'] = trim($_POST['title']);
        $data['id'] = trim($_POST['id']);

        //2. 验证及处理
        //判断分类名称不能为空
        if ($data['title'] === ""){
            $this->jump("index.php?p=admin&c=group&a=add","用户组不能为空",3);
        }
        //不能将当前节点及其子节点作为上级节点
        $groupModel = new GroupModel('auth_group');
        //3. 调用模型完成更新操作
        if($groupModel->update($data)){
            $this->jump("index.php?p=admin&c=group&a=index","更新成功",2);
        }else{
            $this->jump("index.php?p=admin&c=group&a=edit&id=".$data['id'],"更新失败",3);
        }

    }

    //删除商品分类
    public function deleteAction(){
        //1. 获取group_id，作为条件
        $id = $_GET['id'] + 0;
        //2. 做一些相应的判断
        //如果不是叶子分类，则不允许删除
        $groupModel = new GroupModel("auth_group");

        //3. 调用模型，完成删除，并给出提示
        if ($groupModel->delete($id)){
            $this->jump('index.php?p=admin&c=group&a=index',"删除用户组成功",2);
        }else {
            $this->jump('index.php?p=admin&c=group&a=index',"删除用户组失败",3);
        }
    }


    //载入给用户组分配权限，只负责展示，提交动作，http://127.0.0.1/shopcz/index.php?p=admin&c=group&a=configAuth
    public function configAuthAction(){

        //1. 获取group_id，作为条件
        $id = $_GET['id'] + 0;

        //实例化用户组表，查看用户组
        $groupModel = new GroupModel('auth_group');
        $group = $groupModel->selectByPk($id);

        //实例化权限表，获取所有权限，并且按照三维数组展现出来
        $accessModel = new AccessModel('auth_rule');
        $accesses    = $accessModel->frontAccess();
//        var_dump($accesses);
//        exit();

        //3.载入编辑表单
        include  CUR_VIEW_PATH."config_auth_edit.html";
    }

    //载入给用户组分配权限，只负责写入表中，提交动作，http://127.0.0.1/shopcz/index.php?p=admin&c=group&a=updateconfigAuth
    public function updateconfigAuthAction(){

//      1. 取到用户组的id，和 权限数组拼成的一个字段
        $data['rules']    =    implode(',',$_POST['acces']);
        $data['id']    =       $_POST['id'];
        var_dump($data);

        //2.实例化取值，然后存入表中
        $groupModel  = new GroupModel('auth_group');
        if($groupModel->update($data)){
            $this->jump('index.php?p=admin&c=group&a=index',"给用户组分配权限成功",3);
        }else{
            $this->jump('index.php?p=admin&c=group&a=configAuth',"给用户组分配权限失败",3);
        }

    }


}