<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-11-06
 * Time: 17:16
 */

class TypeModel extends Model{

    //获取所有的商品类型
    public function  getTypes(){

        $sql = "select * from {$this->table} ORDER BY type_id";
        return $this->db->getAll($sql);
    }

    //获取分页的商品类型
    public function getPageTypes($offset,$pagesize){
        $sql = "SELECT * FROM {$this->table} ORDER BY type_id LIMIT $offset,$pagesize";
        return $this->db->getAll($sql);
    }
}