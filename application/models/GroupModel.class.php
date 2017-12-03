<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/12/2
 * Time: 14:24
 */
class GroupModel extends Model{

    //后台获取所有的用户组信息
    public function  getGroups(){

        $sql = "select * from {$this->table}";
        $groups =  $this->db->getAll($sql);
        return $groups;
    }

}