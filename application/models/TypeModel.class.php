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

    //获取分页的商品类型，改进版，加入了分组函数，分组主要是以便于以后的计算
    public function getPageTypes($offset,$pagesize){
        $sql = "SELECT a.*,COUNT(b.attr_name) AS num  FROM {$this->table} as a LEFT JOIN `cz_attribute` as b
                ON a.type_id = b.type_id GROUP BY a.type_id ORDER BY a.type_id DESC LIMIT $offset,$pagesize";
        return $this->db->getAll($sql);
    }
}

