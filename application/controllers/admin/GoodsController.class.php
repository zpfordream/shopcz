<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-11-14
 * Time: 17:00
 */

class GoodsController extends BaseController{

    //显示添加商品页面，http://127.0.0.1/shopcz_git_project/index.php?p=admin&c=goods&a=add
    public function addAction(){

        //获取分类信息
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->getCats();
        //获取类别信息
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->getTypes();
        //获取品牌信息，不获取了，直接录入了


        include CUR_VIEW_PATH."goods_add.html";
    }

    public function indexAction(){
        include CUR_VIEW_PATH."goods_list.html";
    }

    //显示添加商品操作，http://127.0.0.1/shopcz_git_project/index.php?p=admin&c=goods&a=insert
    public function insertAction(){

        //1.手机表单数据
        $data['goods_name']    =     trim($_POST['goods_name']);
        $data['goods_sn']    =     trim($_POST['goods_name']);
        $data['brand_id']    =     trim($_POST['brand_id']);
        $data['type_id']    =     $_POST['goods_name'];
        $data['show_price']    =     trim($_POST['show_price']);
        $data['market_price']    =     trim($_POST['market_price']);
        $data['promote_start_time']    =    strtotime($_POST['promote_start_time']);
        $data['promote_end_time']    =     strtotime($_POST['promote_end_time']);
        $data['goods_desc']    =     trim($_POST['goods_desc']);
        $data['add_time']    =     time();
        $data['is_best']    =     isset($_POST['is_best']) ? $_POST['is_best']: 0 ;
        $data['is_new']    =     isset($_POST['is_new']) ? $_POST['is_best']: 0 ;
        $data['is_hot']    =     isset($_POST['is_hot']) ? $_POST['is_best']: 0 ;
        $data['is_onsale']    =     isset($_POST['is_onsale']) ? $_POST['is_best']: 0 ;
        $data['market_price']    =     trim($_POST['market_price']);


    }


}