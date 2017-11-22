<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-11-21
 * Time: 12:52
 */


class IndexController extends Controller{

    //http://127.0.0.1/shoucz/index.php?p=home&c=index&a=index
    public function indexAction(){

        //获取左边的导航
        $categoryModel = new CategoryModel('category');
        $cats = $categoryModel->frontCats();
//        var_dump($cats);

        //获取推荐商品
        $goodsModel = new GoodsModel('goods');
        $bestGoods = $goodsModel->getBestGoods();
       // var_dump($bestGoods);


        include CUR_VIEW_PATH."index.html";
    }


}