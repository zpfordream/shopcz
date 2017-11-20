<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-10-20
 * Time: 9:42
 */

class CategoryModel extends Model{

    //获取所有的分类信息
    public function  getCats(){

        $sql = "select * from {$this->table}";
        $cats =  $this->db->getAll($sql);
        return $this->tree($cats);
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

            if($v['parent_id'] ==$pid){
                $v['level'] = $level ;
                $tree[] = $v ;
                $this->tree($arr , $v['cat_id'],$level+1);
            }
        }
        return $tree;
    }

    //定义一个方法，获取一个节点的所有子节点
    public function getSubIds($pid){
        $sql  = "select * from {$this->table}";
        $cats =  $this ->db->getAll($sql);
        $cats = $this ->tree($cats,$pid);
        $list = array();
        foreach($cats as $cat){
            $list[] = $cat['cat_id'];
        }
        return $list;
    }

}