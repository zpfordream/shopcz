<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-11-06
 * Time: 16:50
 */


class TypeController extends Controller{

    //展示添加页面, http://127.0.0.1/shopcz/index.php?p=admin&c=Type&a=add
    public function addAction(){
        include CUR_VIEW_PATH."goods_type_add.html";
    }


    //添加的动作, http://127.0.0.1/shopcz/index.php?p=admin&c=Type&a=insert
    public function insertAction(){

        //1. 收集表单数据
        $data['type_name']    =    trim($_POST['type_name']);

        //2.验证及处理
        //判断分类名称不能为空
        if($data['type_name'] === ""){
            $this->jump("index.php?p=admin&c=Type&a=add","类型名称不能为空",3);
        }

        //3. 调用模型，完成入库，并给于提示
        $typeModel = new TypeModel("goods_type");
        if($typeModel->insert($data)){
            $this ->jump("index.php?p=admin&c=Type&a=add","添加类型成功",3);
        }else{
            $this ->jump("index.php?p=admin&c=Type&a=add","添加类型失败",3);
        }

    }

    //类别列表, http://127.0.0.1/shopcz/index.php?p=admin&c=Type&a=index
    public function indexAction(){

        $typeModel = new TypeModel("goods_type");
        //$types = $typeModel->getTypes();
        //var_dump($types);

        //获取当前分页，通过url参数，默认是1
        $current = isset($_GET['page'])? $_GET['page'] : 1  ;
        //获取每页的条数
        $pagesize = 2;
        //计算偏移量
        $offset = ($current - 1) * $pagesize;
        //获取每一页的列表
        $types = $typeModel->getPageTypes($offset,$pagesize);
        var_dump($types);

        //使用分页类来获取分页信息
        $where = "";
        $total = $typeModel->total($where);
        $this->library("Page");
        $page = new Page($total,$pagesize,$current,"index.php",array("p"=>"admin","c"=>"Type","a"=>"index"));
        $pageinfo = $page->showPage();

        include CUR_VIEW_PATH."goods_type_list.html";
    }


}