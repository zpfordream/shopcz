<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/12/3
 * Time: 9:56
 */

class UserController extends BaseController{

    //添加用户的添加页面 http://127.0.0.1/shopcz/index.php?p=admin&c=user&a=add
    public  function  addAction(){

        //取得所有用户组，传到前台
        $groupModel = new GroupModel("auth_group");
        $groups    =   $groupModel->getGroups();

        include  CUR_VIEW_PATH."user_add.html";
    }



    //插入后台的数据 http://127.0.0.1/shopcz/index.php?p=admin&c=user&a=insert
    public function  insertAction(){

        var_dump($_POST);
        exit();

        //1. 收集表单数据
        $data['user_name']      =    trim($_POST['user_name']);
        $data['password']      =    trim($_POST['password']);
        $data['email']            =    trim($_POST['email']);
        $data['status']         =      $_POST['radio']  ;

        $group_ids             =       $_POST['group_ids'];

//        var_dump($_POST);
//        exit;

        //2.验证及处理
        //判断分类名称不能为空
        if($data['user_name'] === ""){
            $this->jump("index.php?p=admin&c=user&a=add","用户名不能为空",3);
        }
        if($data['password'] === ""){
            $this->jump("index.php?p=admin&c=user&a=add","密码不能为空",3);
        }
        if($data['email'] === ""){
            $this->jump("index.php?p=admin&c=user&a=add","email不能为空",3);
        }

        //3. 调用模型，完成入库，并给于提示
        $usersModel = new UserModel("user");
        if($uid = $usersModel->insert($data)){

            //实例化关联表，用户和组的关联表
            $auth_group_id = new Model("auth_group_id");

            //拿到a表的id，然后和b表的内容 ，拼在一起插入b表
            foreach($group_ids as $group_id){

                $group = array(
                    "uid" => $uid ,
                    "groud_id" => $group_id ,
                );

                $auth_group_id ->insert($group);
//                本来想把上条语句放到if中判断，因为insert返回主键，但是表里没设置主键 ，所以错误
//                if( !  ){
//                    $this ->jump("index.php?p=admin&c=user&a=add","添加管理员失败,在往关联表的过程中出现错误",3);
//                }
            }

            $this ->jump("index.php?p=admin&c=user&a=index","添加管理员成功",3);
        }else{
            $this ->jump("index.php?p=admin&c=user&a=add","添加管理员失败",3);
        }
    }






    //用户的列表页 http://127.0.0.1/shopcz/index.php?p=admin&c=user&a=index，需要关联group表
    public  function  indexAction(){

        $userModel = new UserModel('user');
        $users  = $userModel->getUsers();
        //var_dump($users);
        include  CUR_VIEW_PATH."user_list.html";
    }



    //载入编辑分类动作  http://127.0.0.1/shopcz/index.php?p=admin&c=user&a=edit
    public  function  editAction(){
        //1.获取当前分类信息
        $user_id    =    $_GET['user_id'] + 0 ;

        $userModel = new UserModel('user');
        $user     =  $userModel->selectByPk($user_id);
        $oneInGroup = $userModel->oneInGroup($user_id);

        $groupModel = new GroupModel("auth_group");
        $groups = $groupModel->getGroups();

//        var_dump($oneInGroup);
//        var_dump($groups);
//        var_dump($user);
//        exit;
        //3.载入编辑表单
        include  CUR_VIEW_PATH."user_edit.html";
    }

    //载入编辑分类后，修改后，提交动作，http://127.0.0.1/shopcz/index.php?p=admin&c=user&a=updateAction
    public function updateAction(){

//        var_dump($_POST);
//        exit();

        //1. 收集表单数据
        $data['user_name'] = trim($_POST['user_name']);
        $data['password'] = trim($_POST['password']);
        $data['email'] = trim($_POST['email']);
        $data['user_id'] = $_POST['user_id'];
        $data['status'] = $_POST['status'];
        $data['groups'] = $_POST['groups'];

        //2.验证及处理
        //判断分类名称不能为空
        if($data['user_name'] === ""){
            $this->jump("index.php?p=admin&c=user&a=add","用户名不能为空",3);
        }
        if($data['password'] === ""){
            $this->jump("index.php?p=admin&c=user&a=add","密码不能为空",3);
        }
        if($data['email'] === ""){
            $this->jump("index.php?p=admin&c=user&a=add","email不能为空",3);
        }

        $userModel = new UserModel("user");

        //3. 调用模型完成更新操作, 更新函数返回的是影响的行数，不用返回id，因为更新本来就知道id
        //修改a表和c表，通过b表关联，修改b表的内容时，不能通过id找到后修改，而是把原来的关联表内容删除后，再重新插入关联数据
        if($userModel->update($data)){

            //实例化关联表，用户和组的关联表
            $auth_group_id = new Model("auth_group_id");


            //拿到a表的id，然后和b表的内容 ，拼在一起插入b表
            foreach( $data['groups'] as $group_id) {

                $group = array(
                    "uid" => $data['user_id'],
                    "groud_id" => $group_id,
                );

                $auth_group_id->update($group);
            }
            $this->jump("index.php?p=admin&c=user&a=index","更新成功",2);
        }else{
            $this->jump("index.php?p=admin&c=user&a=edit&cat_id=".$data['user_id'],"更新失败",3);
        }

    }

    //删除商品分类
    public function deleteAction(){
        //1. 获取cat_id，作为条件
        $user_id = $_GET['user_id'] + 0;
        //2. 做一些相应的判断
        //如果不是叶子分类，则不允许删除
        $userModel = new UserModel("user");

        //3. 调用模型，完成删除，并给出提示
        if ($userModel->delete($user_id)){
            $this->jump('index.php?p=admin&c=user&a=index',"删除用户成功",2);
        }else {
            $this->jump('index.php?p=admin&c=user&a=index',"删除用户失败",3);
        }
    }





}