<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-11-14
 * Time: 17:00
 */

class GoodsController extends BaseController{

    //显示添加商品页面，http://127.0.0.1/shopcz/index.php?p=admin&c=goods&a=add
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

}