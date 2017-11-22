<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/21
 * Time: 22:52
 */


class GoodsModel extends Model{

    //前台，获取推荐商品
    public function getBestGoods(){
        $sql = "SELECT * FROM {$this->table} WHERE is_best = 1 AND is_onsale = 1 ORDER BY add_time DESC LIMIT 4 ";
        return $this->db->getAll($sql);
    }



}