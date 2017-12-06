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

    //后台获取，单个用户组分配的权限id，用数组返回 ，以便在编辑页面查看哪些被选中，哪些未被选中，in_array, 如果一个权限在这个array中，就是被选中了
    /**
     * @param $id  用户组id
     * @return array 返回rule的一维数组
     */
    public function  ruleInGroup( $id ){

        $sql = "select rules from {$this->table} WHERE id = {$id}";
        $tmp =  $this->db->getAll($sql);
        //getAll返回的是二维数组，所以需要tmp 取临时接一下;
//        var_dump($tmp[0]['rules']);
        $rules = explode(',',$tmp[0]['rules']);
//        var_dump($rules);
//        exit();
        return $rules;
    }



}