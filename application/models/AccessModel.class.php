<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-12-05
 * Time: 14:16
 */
class AccessModel extends Model{

    //后台获取所有的分类信息
    public function  getAccess(){

        $sql = "select * from {$this->table}";
        $access =  $this->db->getAll($sql);
        return $this->tree($access);
    }

    /**
     * @param $arr   array 给定要排列的数组
     * @param int $pid  int 制定从哪个节点找
     * @param int $level 前面缩进的距离
     * @return array 构造好的数组
     */
    public function  tree($arr,$pid=0,$level=0){

        static  $tree =array();
        foreach($arr as $v){

            if($v['pid'] ==$pid){
                $v['level'] = $level ;
                $tree[] = $v ;
                $this->tree($arr , $v['id'],$level+1);
            }
        }
        return $tree;
    }


    //后台，定义一个方法，获取一个节点的所有子节点
    public function getSubIds($pid){
        $sql  = "select * from {$this->table}";
        $accesses =  $this ->db->getAll($sql);
        $accesses = $this ->tree($accesses,$pid);
        $list = array();
        foreach($accesses as $access){
            $list[] = $access['id'];
        }
        return $list;
    }


    //，找到子节点，就继续找，并将其保存到 下标为child的元素中，将二维护组转化成多维数组
    public function childList($arr,$pid=0){
        $list = array();
        foreach($arr as $v){
            if($v['pid'] == $pid){
                //说明找到子节点了，将该节点作为当前节点找其后代节点
                $child = $this->childList($arr , $v['id']);
                //将子节点这个数组，变成原数组的多一维数组
                $v['child'] = $child;
                $list[] = $v;
            }
        }
        return $list;
    }

    //用在权限列表，用户组页面点击分配权限，获取所有的权限数据，并构造成多维数组
    public function frontAccess(){
        $sql = "SELECT * from {$this->table} ";
        $accesses = $this->db->getAll($sql);
        return $this->childList($accesses);
    }
}