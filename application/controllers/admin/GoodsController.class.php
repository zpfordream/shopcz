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

    //显示添加商品操作，http://127.0.0.1/shopcz_git_project/index.php?p=admin&c=goods&a=insert,难点是多表插入
    public function insertAction(){

        var_dump($_POST);
        var_dump($_FILES);


        //1.手机表单数据
        $data['goods_name']    =     trim($_POST['goods_name']);
        $data['goods_sn']    =     trim($_POST['goods_name']);
        $data['cat_id']    =     trim($_POST['cat_id']);
        $data['brand_id']    =     trim($_POST['brand_id']);
        $data['shop_price']    =     trim($_POST['shop_price']);
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

        //处理图片上传
        $this->library('upload');
        $upload = new upload(UPLOAD_PATH);

        if($file_name = $upload->up($_FILES['goods_img'])){
            //成功
            $data['goods_img'] =  $file_name;
        } else {
             $this->jump('index.php?p=admin&c=goods&a=add',$upload->error(),3);
        }

        //2.验证及处理

        //3.调用函数完成入库，并给出提示
        //由于是先得插入商品表，所以要返回商品表的id，然后在写入goods_attr表

        $goodsModel = new GoodsModel('goods');
        if($goods_id = $goodsModel->insert($data)){

            //收集表单，准备插入goods_attr表
            $attr_ids = $_POST['attr_id_list'];
            $attr_values = $_POST['attr_value_list'];
            $attr_price = $_POST['attr_price_list'];

            //批量插入
            foreach( $attr_ids as $k=>$v ){
                $list['goods_id']  = $goods_id;
                $list['attr_id']  = $v;
                $list['attr_value']  = $attr_values[$k];
                $list['attr_price']  = $attr_price[$k];

                //调用空模型完成入库，Goods_attr是中间表，即关联表，其实和 附带在其他控制器中的，它自己没有独立的控制器。
                $emptyModel = new Model('goods_attr');
                $emptyModel->insert($list);
            }
            $this->jump('index.php?p=admin&c=goods&a=index',"商品添加成功",3);

        }else{
            $this->jump('index.php?p=admin&c=goods&a=add',"商品添加失败",3);
        }
    }


}