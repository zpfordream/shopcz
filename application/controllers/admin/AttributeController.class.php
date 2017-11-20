<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-11-08
 * Time: 12:58
 */

class AttributeController extends Controller{

    //单个类型下的属性列表页面,http://127.0.0.1/shopcz/index.php?p=admin&c=Attribute&a=index
    public function indexAction(){

        //在页面顶端，按照商品类型显示
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->getTypes();

        $attrModel = new AttributeModel("attribute");
        //接受type_id
        $type_id = $_GET['type_id'] + 0;

        //获取当前页
        $current = isset($_GET['page'])? $_GET['page'] : 1 ;

        //每一页的分页数
        $pagesize = 2;

        //总的记录数
        $where = "type_id = {$type_id}";
        $total  = $attrModel->total($where);

        //计算offset
        $offset = ( $current -1 )* $pagesize ;

        //分页获取该类型下的所有的属性
        $attrs = $attrModel->getPageAttrs($type_id,$offset,$pagesize);

        //实例化分页信息
        $this->library("Page");
        $page = new Page($total,$pagesize,$current,'index.php',array('p'=>'admin','c'=>'attribute','a'=>'index','type_id'=>$type_id));
        $pageinfo = $page->showPage();


        //在页面顶端，按照商品类型显示
        $typeModel = new TypeModel('goods_type');
        $types = $typeModel->getTypes();

        var_dump($types);

        var_dump($attrs);
        include CUR_VIEW_PATH."attribute_list.html";
    }



    //展示添加页面,http://127.0.0.1/shopcz/index.php?p=admin&c=Attribute&a=add
    public function addAction(){

        //1.获取所有的商品类型
        $typeModel = new TypeModel("goods_type");
        $types = $typeModel->getTypes();

        include  CUR_VIEW_PATH."attribute_add.html";
    }

    //插入数据库操作,http://127.0.0.1/shopcz/index.php?p=admin&c=Attribute&a=insert
    public function insertAction(){

        //1.获取表单数据
        $data['attr_name'] = $_POST['attr_name'];
        $data['type_id'] = $_POST['type_id'];
        $data['attr_type'] = $_POST['attr_type'];
        $data['attr_input_type'] = $_POST['attr_input_type'];
        $data['attr_value'] = isset($_POST['attr_value'])?$_POST['attr_value']:"";

        //2.验证及处理，和别的一样


        //3.调用模型，完成入库，并给出提示
        $attrModel = new AttributeModel("attribute");
        if($attrModel->insert($data)){
            $this->jump("index.php?p=admin&c=Attribute&a=index&type_id=".$data['type_id'],"添加属性成功",3);
        }else{
            $this->jump("index.php?p=admin&c=Attribute&a=add","添加属性失败",3);
        }

    }

    //获取指定类型下的属性 http://127.0.0.1/shopcz/index.php?p=admin&c=Attribute&a=getAttrs
    public  function getAttrsAction(){

        $type_id = $_GET['type_id']+0;
        $attrModel =  new AttributeModel('attribute');
        $attrs = $attrModel->getAttrsForm($type_id);

        echo <<<STR
<script type="text/javascript">
                window.parent.document.getElementById("tbody-goodsAttr").innerHTML ="$attrs";
</script>
STR;


    }



}
